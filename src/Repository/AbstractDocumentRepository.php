<?php

namespace Bacart\Bundle\MongoDBBundle\Repository;

use Bacart\Bundle\MongoDBBundle\Document\AbstractDocument;
use Bacart\Bundle\MongoDBBundle\Exception\RepositoryDocumentNotFoundException;
use Bacart\SymfonyCommon\Aware\Interfaces\LoggerAwareInterface;
use Bacart\SymfonyCommon\Aware\Traits\LoggerAwareTrait;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use Doctrine\Bundle\MongoDBBundle\Repository\ServiceDocumentRepository;
use Doctrine\Common\Annotations\AnnotationException;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ODM\MongoDB\LockMode;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Document;
use Doctrine\ODM\MongoDB\MongoDBException;
use Doctrine\ODM\MongoDB\Query\Builder;

/**
 * @method AbstractDocument|null findOneBy(array $criteria)
 * @method AbstractDocument|null find($id, $lockMode = LockMode::NONE, $lockVersion = null)
 * @method AbstractDocument[]    findBy(array $criteria, array $sort = null, $limit = null, $skip = null)
 * @method AbstractDocument[]    findAll()
 */
abstract class AbstractDocumentRepository extends ServiceDocumentRepository implements DocumentRepositoryInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    /** @var AnnotationReader */
    protected $annotationReader;

    /**
     * @param ManagerRegistry $registry
     *
     * @throws RepositoryDocumentNotFoundException
     * @throws AnnotationException
     */
    public function __construct(ManagerRegistry $registry)
    {
        $this->annotationReader = new AnnotationReader();

        /** @var ObjectManager $manager */
        foreach ($registry->getManagers() as $manager) {
            foreach ($manager->getMetadataFactory()->getAllMetadata() as $metadata) {
                $reflectionClass = $metadata->getReflectionClass();
                $repositoryClass = $this->getDocumentRepository($reflectionClass);

                if (static::class === $repositoryClass) {
                    parent::__construct($registry, $reflectionClass->getName());

                    return;
                }
            }
        }

        throw new RepositoryDocumentNotFoundException(static::class);
    }

    /**
     * {@inheritdoc}
     */
    public function createQueryBuilder(array $criteria = null): Builder
    {
        $queryBuilder = parent::createQueryBuilder();

        if (null !== $criteria) {
            $queryBuilder->setQueryArray($criteria);
        }

        return $queryBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function count(array $criteria = null): ?int
    {
        try {
            return $this->createQueryBuilder($criteria)
                ->hydrate(false)
                ->count()
                ->getQuery()
                ->execute();
        } catch (\InvalidArgumentException | MongoDBException $e) {
            $this->error($e, get_defined_vars());
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function distinct(string $fieldName, array $criteria = null): ?iterable
    {
        try {
            return $this->createQueryBuilder($criteria)
                ->distinct($fieldName)
                ->getQuery()
                ->execute();
        } catch (\InvalidArgumentException | MongoDBException $e) {
            $this->error($e, get_defined_vars());
        }

        return null;
    }

    /**
     * @param \ReflectionClass $reflectionClass
     *
     * @return string|null
     */
    protected function getDocumentRepository(\ReflectionClass $reflectionClass): ?string
    {
        $annotations = $this->annotationReader->getClassAnnotations($reflectionClass);

        foreach ($annotations as $annotation) {
            if ($annotation instanceof Document) {
                return $annotation->repositoryClass;
            }
        }

        return null;
    }
}
