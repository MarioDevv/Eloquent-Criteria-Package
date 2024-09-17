<?php
namespace Mariodevv\phpcriteriapackage\Domain\Criteria\Filters;

use Mariodevv\phpcriteriapackage\Domain\Criteria\Filter;



class BetweenFilter implements QueryFilter
{
    public function apply(\Illuminate\Database\Eloquent\Builder $query, Filter $filter): \Illuminate\Database\Eloquent\Builder
    {
        return $query->whereBetween($filter->field->value, $filter->value->value);
    }
}