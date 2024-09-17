<?php
declare (strict_types = 1);

namespace Mariodevv\EloquentCriteriaPackage\Domain\Criteria;

class FilterValue
{
    public function __construct(public readonly mixed $value)
    {}
}
