<?php

namespace DiscountAPI\Domain\Service;

use DiscountAPI\Domain\Entity\Discount;
use DiscountAPI\Domain\Entity\DiscountableOrder;
use DiscountAPI\Domain\Entity\Order;

readonly class OrderDiscount
{
    public function __construct(
        private DiscountableOrder $order,
        private DiscountStrategy  $discountCalculator
    )
    {
    }

    public function calculateDiscounts(): Discount
    {
        return $this->discountCalculator->calculate($this->order);
    }
}
