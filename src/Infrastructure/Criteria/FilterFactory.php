<?php

namespace Mariodevv\phpcriteriapackage\Infrastructure\Criteria;

use Mariodevv\phpcriteriapackage\Domain\Criteria\Operator;
use Mariodevv\phpcriteriapackage\Domain\Criteria\FilterOperator;
use Mariodevv\phpcriteriapackage\Domain\Criteria\Filters\LikeFilter;
use Mariodevv\phpcriteriapackage\Domain\Criteria\Filters\QueryFilter;
use Mariodevv\phpcriteriapackage\Domain\Criteria\Filters\IsNullFilter;
use Mariodevv\phpcriteriapackage\Domain\Criteria\Filters\BetweenFilter;
use Mariodevv\phpcriteriapackage\Domain\Criteria\Filters\EqualFilter;
use Mariodevv\phpcriteriapackage\Domain\Criteria\Filters\RelationFilter;
use Mariodevv\phpcriteriapackage\Domain\Criteria\Filters\IsNotNullFilter;
use Mariodevv\phpcriteriapackage\Domain\Criteria\Filters\NotLikeFilter;


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
