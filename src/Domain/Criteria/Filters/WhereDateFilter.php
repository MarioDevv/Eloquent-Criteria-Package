<?php

namespace Mariodevv\phpcriteriapackage\Domain\Criteria\Filters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Mariodevv\phpcriteriapackage\Domain\Criteria\Filter;

class WhereDateFilter implements QueryFilter
{
    public function apply(Builder $query, Filter $filter): Builder
    {
        // Convertimos la fecha al formato Y-m-d usando Carbon
        $formattedDate = Carbon::parse($filter->value->value)->format('Y-m-d');

        return $query->whereDate($filter->field->value, $formattedDate);
    }
}
