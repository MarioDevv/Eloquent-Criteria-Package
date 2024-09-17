<?php
declare (strict_types = 1);

namespace Mariodevv\EloquentCriteriaPackage\Domain\Criteria;

enum Operator: string {
    case EQUAL = '=';
    case NOT_EQUAL = '!=';
    case GREATER_THAN = '>';
    case GREATER_THAN_OR_EQUAL = '>=';
    case LESS_THAN = '<';
    case LESS_THAN_OR_EQUAL = '<=';
    case LIKE = 'like';
    case NOT_LIKE = 'not like';
    case BETWEEN = 'between';
    case IS_NULL = 'is null';
    case IS_NOT_NULL = 'is not null';
    case WHERE_DATE = 'whereDate';
    
}

class FilterOperator
{
    public function __construct(public readonly Operator $value)
    {}

    public function equals(Operator $operator): bool
    {
        return $this->value->value === $operator->value;
    }
}
