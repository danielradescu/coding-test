<?php

namespace DiscountAPI\Domain\Entity;

use DiscountAPI\Domain\ValueObject\Money;

readonly class Order implements DiscountableOrder
{
    public function __construct(
        private string   $id,
        private Customer $customer,
        private array    $items,
        private Money    $total
    )
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getTotal(): Money
    {
        return $this->total;
    }
}