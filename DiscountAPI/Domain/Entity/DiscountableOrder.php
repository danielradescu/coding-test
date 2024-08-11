<?php

namespace DiscountAPI\Domain\Entity;

use DiscountAPI\Domain\ValueObject\Money;

interface DiscountableOrder
{

    public function getCustomer(): Customer;

    public function getItems(): array;

    public function getTotal(): Money;
}