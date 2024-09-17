<?php

namespace Mariodevv\EloquentCriteriaPackage\Domain\Criteria;

interface QueryAdapter
{
    public function applyFilter(Filter $filter): void;
    
    public function applyOrder(Order $order): void;

    public function getQuery();
}
