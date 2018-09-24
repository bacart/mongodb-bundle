<?php

namespace Bacart\Bundle\MongoDBBundle\Repository;

use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use Doctrine\ODM\MongoDB\Query\Builder;

interface DocumentRepositoryInterface
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry);

    /**
     * @param array|null $criteria
     *
     * @return Builder
     */
    public function createQueryBuilder(array $criteria = null): Builder;

    /**
     * @param array|null $criteria
     *
     * @return int|null
     */
    public function count(array $criteria = null): ?int;

    /**
     * @param string     $fieldName
     * @param array|null $criteria
     *
     * @return iterable|null
     */
    public function distinct(string $fieldName, array $criteria = null): ?iterable;
}
