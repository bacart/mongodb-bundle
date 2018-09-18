<?php

namespace Bacart\Bundle\MongoDBBundle\Repository;

use Bacart\Bundle\MongoDBBundle\Document\AbstractDocument;
use Bacart\Bundle\MongoDBBundle\Exception\RepositoryException;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Doctrine\ODM\MongoDB\LockMode;
use Doctrine\ODM\MongoDB\MongoDBException;
use Doctrine\ODM\MongoDB\Query\Builder;

/**
 * @method AbstractDocument|null findOneBy(array $criteria)
 * @method AbstractDocument|null find($id, $lockMode = LockMode::NONE, $lockVersion = null)
 * @method AbstractDocument[]    findBy(array $criteria, array $sort = null, $limit = null, $skip = null)
 * @method AbstractDocument[]    findAll()
 */
class AbstractDocumentRepository extends DocumentRepository
{
    /**
     * {@inheritdoc}
     *
     * @param array|null $criteria
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
     * @param array|null $criteria
     *
     * @throws RepositoryException
     *
     * @return int
     */
    public function count(array $criteria = null): int
    {
        try {
            return $this->createQueryBuilder($criteria)
                ->hydrate(false)
                ->count()
                ->getQuery()
                ->execute();
        } catch (\InvalidArgumentException | MongoDBException $e) {
            throw new RepositoryException($e);
        }
    }

    /**
     * @param string     $fieldName
     * @param array|null $criteria
     *
     * @throws RepositoryException
     *
     * @return mixed // TODO: check, maybe : ?array
     */
    public function distinct(string $fieldName, array $criteria = null)
    {
        try {
            return $this->createQueryBuilder($criteria)
                ->distinct($fieldName)
                ->getQuery()
                ->execute();
        } catch (\InvalidArgumentException | MongoDBException $e) {
            throw new RepositoryException($e);
        }
    }
}
