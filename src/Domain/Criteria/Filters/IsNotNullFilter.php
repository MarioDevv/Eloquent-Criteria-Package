<?php
namespace Mariodevv\EloquentCriteriaPackage\Domain\Criteria\Filters;

use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\Filter;


class IsNotNullFilter implements QueryFilter
{
    public function apply(\Illuminate\Database\Eloquent\Builder $query, Filter $filter): \Illuminate\Database\Eloquent\Builder
    {
        return $query->whereNotNull($filter->field->value);
    }
}