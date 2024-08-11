<?php

namespace DiscountAPI\Domain\ValueObject;

use InvalidArgumentException;

class Money
{
    public function __construct(
        private readonly float  $amount = 0,
        private readonly string $currency = 'EUR'
    )
    {
    }

    public function add(Money $money): Money
    {
        if ($this->currency !== $money->getCurrency()) {
            throw new InvalidArgumentException("Currencies must match");
        }
        return new Money($this->amount + $money->getAmount(), $this->currency);
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getAmount(): float
    {
        return round($this->amount, 2);
    }

}