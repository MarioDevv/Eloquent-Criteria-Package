<?php
declare (strict_types = 1);

namespace Mariodevv\phpcriteriapackage\Domain\Criteria;


class Order
{

    public function __construct(
        public readonly OrderBy $orderBy,
        public readonly OrderType $orderType
    ) {}

    public static function none(): self
    {
        return new Order(new OrderBy(''), new OrderType(OrderTypes::NONE));
    }

    public static function fromValues(?string $orderBy, ?string $orderType): self
    {
        return $orderBy !== null
        ? new Order(new OrderBy($orderBy), new OrderType(OrderTypes::from($orderType)))
        : self::none();
    }

    public function isNone(): bool
    {
        return $this->orderType->isNone();
    }

}
