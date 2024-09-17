<?php
namespace Mariodevv\phpcriteriapackage\Domain\Criteria\Filters;

use Mariodevv\phpcriteriapackage\Domain\Criteria\Filter;



class EqualFilter implements QueryFilter
{
    public function apply(\Illuminate\Database\Eloquent\Builder $query, Filter $filter): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where($filter->field->value, $filter->operator->value->value, $filter->value->value);
    }
}