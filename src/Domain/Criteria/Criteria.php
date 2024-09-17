<?php
declare(strict_types=1);

namespace Mariodevv\EloquentCriteriaPackage\Domain\Criteria;


class Criteria
{
    public function __construct(
        public readonly Filters $filters,
        public readonly Order $order,
        public readonly int $pageNumber,
        public readonly int $pageSize,
        public readonly array $relations = []

    ) {
        $this->ensurePagination();
    }

    public static function fromValues(
        string $orderBy = 'created_at',
        string $orderType = 'desc',
        int $pageNumber = 1,
        int $pageSize = 10,
        array $filters = [],
        array $relations = []
    ): self {
        return new self(
            Filters::fromArray($filters),
            Order::fromValues($orderBy, $orderType),
            $pageNumber,
            $pageSize,
            $relations
        );
    }


    public static function none(): self
    {
        return new self(
            new Filters([]),
            Order::none(),
            1,
            10
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
