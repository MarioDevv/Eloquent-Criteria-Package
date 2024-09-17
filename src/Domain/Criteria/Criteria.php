<?php
declare(strict_types=1);

namespace Mariodevv\EloquentCriteriaPackage\Domain\Criteria;


class Criteria
{
    public function __construct(
        public readonly Filters $filters,
        public readonly Order $order,
        public readonly ?int $pageSize,
        public readonly ?int $pageNumber,
        public readonly array $relations = []

    ) {
        $this->ensurePagination();
    }

    public static function fromValues(
        ?string $orderBy,
        ?string $orderType,
        int $pageSize = null,
        int $pageNumber = null,
        array $filters = [],
        array $relations = []
    ): self {
        return new self(
            Filters::fromArray($filters),
            Order::fromValues($orderBy, $orderType),
            $pageSize,
            $pageNumber,
            $relations
        );
    }

    public function hasOrder(): bool
    {
        return !$this->order->isNone();
    }

    public function hasFilters(): bool
    {
        return !$this->filters->isEmpty();
    }

    public function hasRelations(): bool
    {
        return !empty($this->relations);
    }

    public function getFilterValue(string $field): mixed
    {
        return $this->filters->getValue($field);
    }

    private function ensurePagination(): void
    {
        if ($this->pageSize === null || $this->pageNumber === null) {
            throw new \InvalidArgumentException('Page size and number are required');
        }
    }
}
