<?php

namespace DiscountAPI\Domain\Entity;

use DiscountAPI\Domain\ValueObject\Money;

readonly class OrderItem
{
    public function __construct(
        private Product $product,
        private int     $quantity,
        private float   $unitPrice,
        private Money   $total
    )
    {
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getUnitPrice(): float
    {
        return $this->unitPrice;
    }

    public function getTotal(): Money
    {
        return $this->total;
    }
}