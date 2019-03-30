<?php

/*
 * This file is part of the Bacart package.
 *
 * (c) Alex Bacart <alex@bacart.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bacart\Bundle\MongoDBBundle\Repository;

use Bacart\Bundle\MongoDBBundle\Document\AbstractDocument;
use Bacart\SymfonyCommon\Aware\Interfaces\LoggerAwareInterface;
use Bacart\SymfonyCommon\Aware\Traits\LoggerAwareTrait;
use Bacart\SymfonyCommon\Repository\AbstractServiceDocumentRepository;
use Doctrine\ODM\MongoDB\LockMode;
use Doctrine\ODM\MongoDB\MongoDBException;
use Doctrine\ODM\MongoDB\Query\Builder;
use InvalidArgumentException;

/**
 * @method AbstractDocument|null findOneBy(array $criteria)
 * @method AbstractDocument|null find($id, $lockMode = LockMode::NONE, $lockVersion = null)
 * @method AbstractDocument[]    findBy(array $criteria, array $sort = null, $limit = null, $skip = null)
 * @method AbstractDocument[]    findAll()
 */
abstract class AbstractDocumentRepository extends AbstractServiceDocumentRepository implements DocumentRepositoryInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

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
        } catch (InvalidArgumentException | MongoDBException $e) {
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
        } catch (InvalidArgumentException | MongoDBException $e) {
            $this->error($e, get_defined_vars());
        }

        return null;
    }
}
