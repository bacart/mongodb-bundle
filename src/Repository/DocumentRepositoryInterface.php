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

use Doctrine\ODM\MongoDB\Query\Builder;

interface DocumentRepositoryInterface
{
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
