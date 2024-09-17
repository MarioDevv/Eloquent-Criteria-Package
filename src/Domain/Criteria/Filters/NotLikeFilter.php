<?php
namespace Mariodevv\EloquentCriteriaPackage\Domain\Criteria\Filters;

use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\Filter;



class NotLikeFilter implements QueryFilter
{
    public function apply(\Illuminate\Database\Eloquent\Builder $query, Filter $filter): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where($filter->field->value, 'not like', value: '%' . $filter->value->value . '%');
    }
}