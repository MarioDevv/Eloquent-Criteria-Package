<?php
declare (strict_types = 1);

namespace Mariodevv\EloquentCriteriaPackage\Domain\Criteria;

class FilterField {
    public function __construct(public readonly string $value) {}
}
