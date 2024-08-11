<?php

namespace DiscountAPI\Domain\Service\Discount;

use DiscountAPI\Domain\Entity\DiscountableOrder;

class TotalPurchaseDiscount implements DiscountDecorator
{
    private array $reasons = [];

    public function calculateDiscount(DiscountableOrder $order): float
    {
        $discount = 0;
        $customer = $order->getCustomer();

        if ($customer->getRevenue() >= 1000) {
            $this->reasons[] = '10% discount for orders over €1000';
            $discount += $order->getTotal()->getAmount() * 0.10;
        }

        return round($discount, 2);
    }

    public function getDiscountReasons(): array
    {
        return $this->reasons;
    }
}
