<?php

/*
 * This file is part of the Bacart package.
 *
 * (c) Alex Bacart <alex@bacart.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bacart\Bundle\MongoDBBundle\Pagination;

use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\HttpFoundation\Request;

interface PaginatorInterface
{
    /**
     * @param Request $request
     * @param int     $limit
     * @param array   $options
     *
     * @throws \LogicException
     *
     * @return PaginationInterface
     */
    public function getPagination(
        Request $request,
        int $limit = null,
        array $options = []
    ): PaginationInterface;

    /**
     * @return string
     */
    public function getDocumentClass(): string;

    /**
     * @return string[]
     */
    public function getFilters(): array;
}
