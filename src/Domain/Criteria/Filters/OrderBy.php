<?php
declare(strict_types=1);

namespace Mariodevv\phpcriteriapackage\Domain\Criteria;

class OrderBy {
    public function __construct(public readonly string $value) {}
}
