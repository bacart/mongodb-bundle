<?php

namespace Bacart\Bundle\MongoDBBundle\Pagination;

use Bacart\SymfonyCommon\Aware\Interfaces\DocumentManagerAwareInterface;
use Bacart\SymfonyCommon\Aware\Traits\DocumentManagerAwareTrait;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\Paginator;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractPaginator extends Paginator implements PaginatorInterface, DocumentManagerAwareInterface
{
    use DocumentManagerAwareTrait;

    protected const FIRST_PAGE = 1;
    protected const LIMIT = 10;

    /**
     * {@inheritdoc}
     */
    public function getPagination(
        Request $request,
        int $limit = null,
        array $options = []
    ): PaginationInterface {
        $class = $this->getDocumentClass();
        $queryBuilder = $this->documentManager->createQueryBuilder($class);
        $options = array_merge($this->defaultOptions, $options);

        $filterParamName = $options[static::FILTER_FIELD_PARAMETER_NAME];
        $filterValueName = $options[static::FILTER_VALUE_PARAMETER_NAME];

        foreach (array_keys($this->getFilters()) as $filterParam) {
            if ($request->query->get($filterParamName) !== $filterParam) {
                continue;
            }

            if (null !== $filterValue = $request->query->get($filterValueName)) {
                $queryBuilder->field($filterParam)->equals($filterValue);
            }

            break;
        }

        $page = $request->query->get(
            $options[static::PAGE_PARAMETER_NAME],
            static::FIRST_PAGE
        );

        return $this->paginate(
            $queryBuilder,
            $page,
            $limit ?: static::LIMIT,
            $options
        );
    }
}
