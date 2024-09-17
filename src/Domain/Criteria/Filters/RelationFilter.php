<?php
namespace Mariodevv\phpcriteriapackage\Domain\Criteria\Filters;

use Mariodevv\phpcriteriapackage\Domain\Criteria\Filter;


class RelationFilter implements QueryFilter
{
    public function apply(\Illuminate\Database\Eloquent\Builder $query, Filter $filter): \Illuminate\Database\Eloquent\Builder
    {
        $relationPath = implode('.', $filter->relations);
        $field = $filter->field->value;

        return $query->whereHas($relationPath, function ($relatedQuery) use ($field, $filter) {
            return $relatedQuery->where($field, $filter->operator->value->value, $filter->value->value);
        });
    }
}
