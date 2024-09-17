<?php

namespace Mariodevv\EloquentCriteriaPackage\Domain\Criteria\Filters;

use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\Filter;


interface QueryFilter
{
    public function apply(\Illuminate\Database\Eloquent\Builder $query, Filter $filter): \Illuminate\Database\Eloquent\Builder;
}