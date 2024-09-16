<?php
declare (strict_types = 1);

namespace Src\Shared\Domain\Criteria;

class FilterValue
{
    public function __construct(public readonly ?string $value)
    {}
}
