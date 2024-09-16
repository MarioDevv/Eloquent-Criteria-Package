<?php
declare (strict_types = 1);

namespace Mariodevv\EloquentCriteriaPackage\Domain\Criteria;

class Filters
{

    public function __construct(public readonly array $value)
    {}

    public static function fromArray(array $filters): self
    {
        $filtersArray = [];
        foreach ($filters as $filter) {
            $filtersArray[] = Filter::fromValues($filter['field'], $filter['operator'], $filter['value'], $filter['relations']);
        }

        return new self($filtersArray);
    }

    public function isEmpty(): bool
    {
        return empty($this->value);
    }

    public function getValue(string $field): mixed
    {
        $filter = array_filter($this->value, fn($filter) => $filter->field() === $field);

        return $filter ? $filter[0]->value() : null;
    }
}
