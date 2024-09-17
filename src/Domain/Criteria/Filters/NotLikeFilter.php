<?php
namespace Mariodevv\phpcriteriapackage\Domain\Criteria\Filters;

use Mariodevv\phpcriteriapackage\Domain\Criteria\Filter;



class NotLikeFilter implements QueryFilter
{
    public function apply(\Illuminate\Database\Eloquent\Builder $query, Filter $filter): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where($filter->field->value, 'not like', value: '%' . $filter->value->value . '%');
    }
}