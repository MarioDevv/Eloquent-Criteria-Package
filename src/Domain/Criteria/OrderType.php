<?php
declare (strict_types = 1);

namespace Mariodevv\EloquentCriteriaPackage\Domain\Criteria;

enum OrderTypes: string {
    case ASC = 'asc';
    case DESC = 'desc';
    case NONE = 'none';
}

class OrderType
{
    public function __construct(public readonly OrderTypes $value)
    {}

    public function isNone(): bool
    {
        return $this->value === OrderTypes::NONE;
    }

}
