<?php

namespace DiscountAPI\Domain\Service\Discount;

use DiscountAPI\Domain\Entity\Order;

interface DiscountDecorator
{

    public function calculateDiscount(Order $order): float;

    public function getDiscountReasons(): array;
}