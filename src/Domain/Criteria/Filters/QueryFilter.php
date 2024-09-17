<?php

namespace Mariodevv\phpcriteriapackage\Domain\Criteria\Filters;

use Mariodevv\phpcriteriapackage\Domain\Criteria\Filter;


interface QueryFilter
{
    public function apply(\Illuminate\Database\Eloquent\Builder $query, Filter $filter): \Illuminate\Database\Eloquent\Builder;
}