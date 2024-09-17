<?php

namespace Mariodevv\EloquentCriteriaPackage\Infrastructure\Criteria;

use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\Operator;
use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\FilterOperator;
use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\Filters\LikeFilter;
use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\Filters\QueryFilter;
use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\Filters\IsNullFilter;
use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\Filters\BetweenFilter;
use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\Filters\EqualFilter;
use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\Filters\RelationFilter;
use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\Filters\IsNotNullFilter;
use Mariodevv\EloquentCriteriaPackage\Domain\Criteria\Filters\NotLikeFilter;


class FilterFactory
{
    public static function create(FilterOperator $operator, array $relations = []): QueryFilter
    {

        // Si hay relaciones, se crea un filtro de relaciones
        if (!empty($relations)) {
            return new RelationFilter();
        }

        return match ($operator->value) {
            Operator::IS_NULL => new IsNullFilter(),
            Operator::IS_NOT_NULL => new IsNotNullFilter(),
            Operator::BETWEEN => new BetweenFilter(),
            Operator::LIKE => new LikeFilter(),
            Operator::NOT_LIKE => new NotLikeFilter(),
            Operator::EQUAL => new EqualFilter(),
            default => throw new \InvalidArgumentException("Operador no soportado: " . $operator->value),
        };
    }
}
