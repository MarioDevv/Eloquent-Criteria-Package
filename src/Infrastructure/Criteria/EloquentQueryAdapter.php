<?php

namespace Mariodevv\EloquentCriteriaPackage\Infrastructure\Criteria;

use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\Filter;
use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\Order;
use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\QueryAdapter;
use Illuminate\Database\Eloquent\Builder;

class EloquentQueryAdapter implements QueryAdapter
{
    private Builder $query;

    public function __construct(Builder $query)
    {
        $this->query = $query;
    }
 
    public function applyFilter(Filter $filter): void
    {
        $queryFilter = FilterFactory::create($filter->operator, $filter->relations);
        $this->query = $queryFilter->apply($this->query, $filter);
    }

    public function applyOrder(Order $order): void
    {
        $orderBy = $order->orderBy->value;
        $orderType = $order->orderType->value->value;
        $this->query = $this->query->orderBy($orderBy, $orderType);
    }

    public function getQuery(): Builder
    {
        return $this->query;
    }
}
