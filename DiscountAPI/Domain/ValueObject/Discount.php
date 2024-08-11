<?php

namespace DiscountAPI\Domain\ValueObject;

use InvalidArgumentException;

class Discount
{

    public function __construct(
        private readonly float $amount,
        private readonly array $reasons
    )
    {
        if ($amount < 0) {
            throw new InvalidArgumentException("Discount amount cannot be negative");
        }
    }

    public function add(Discount $discount): Discount
    {
        $newAmount = $this->amount + $discount->getAmount();
        $newReason = array_merge($this->reasons, $discount->getReasons());
        return new Discount($newAmount, $newReason);
    }

    public function getAmount(): float
    {
        return round($this->amount, 2);
    }

    public function getReasons(): array
    {
        return $this->reasons;
    }
}