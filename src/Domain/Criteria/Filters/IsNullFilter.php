<?php
namespace Mariodevv\phpcriteriapackage\Domain\Criteria\Filters;

use Mariodevv\phpcriteriapackage\Domain\Criteria\Filter;


class IsNullFilter implements QueryFilter
{
    public function apply(\Illuminate\Database\Eloquent\Builder $query, Filter $filter): \Illuminate\Database\Eloquent\Builder
    {
        return $query->whereNull($filter->field->value);
    }
}