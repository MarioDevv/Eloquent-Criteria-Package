<?php

namespace Mariodevv\EloquentCriteriaPackage\Domain\Criteria\Filters;

use Carbon\Carbon;
use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\Filter;


class WhereDateFilter implements QueryFilter
{
    public function apply(\Illuminate\Database\Eloquent\Builder $query, Filter $filter): \Illuminate\Database\Eloquent\Builder
    {
        return $query->whereDate($filter->field->value, Carbon::parse($filter->value->value));
    }
}

