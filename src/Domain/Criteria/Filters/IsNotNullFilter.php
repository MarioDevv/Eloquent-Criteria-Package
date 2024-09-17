<?php
namespace Mariodevv\phpcriteriapackage\Domain\Criteria\Filters;

use Mariodevv\phpcriteriapackage\Domain\Criteria\Filter;


class IsNotNullFilter implements QueryFilter
{
    public function apply(\Illuminate\Database\Eloquent\Builder $query, Filter $filter): \Illuminate\Database\Eloquent\Builder
    {
        return $query->whereNotNull($filter->field->value);
    }
}