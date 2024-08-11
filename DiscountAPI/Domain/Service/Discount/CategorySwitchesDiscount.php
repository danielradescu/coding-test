<?php

namespace DiscountAPI\Domain\Service\Discount;

use DiscountAPI\Domain\Entity\DiscountableOrder;

class CategorySwitchesDiscount implements DiscountDecorator
{
    private array $reasons = [];

    public function calculateDiscount(DiscountableOrder $order): float
    {
        $discount = 0;
        $count = 0;
        $unitPrice = 0;

        foreach ($order->getItems() as $orderItem) {
            if ($orderItem->getProduct()->getCategory() === '2') {
                $count += $orderItem->getQuantity();
                $unitPrice = $orderItem->getProduct()->getPrice();
            }
        }

        if ($count >= 6) {
            $this->reasons[] = 'Buy five, get the sixth free for category Switches';
            $discount += (int)($count / 6) * $unitPrice;
        }

        return round($discount, 2);
    }

    public function getDiscountReasons(): array
    {
        return $this->reasons;
    }
}
