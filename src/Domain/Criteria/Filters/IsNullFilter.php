<?php
namespace Mariodevv\EloquentCriteriaPackage\Domain\Criteria\Filters;

use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\Filter;


class IsNullFilter implements QueryFilter
{
    public function apply(\Illuminate\Database\Eloquent\Builder $query, Filter $filter): \Illuminate\Database\Eloquent\Builder
    {
        return $query->whereNull($filter->field->value);
    }
}