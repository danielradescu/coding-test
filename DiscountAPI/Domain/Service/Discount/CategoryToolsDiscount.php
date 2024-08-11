<?php

namespace DiscountAPI\Domain\Service\Discount;

use DiscountAPI\Domain\Entity\Order;

class CategoryToolsDiscount implements DiscountDecorator
{
    private array $reasons = [];

    public function calculateDiscount(Order $order): float
    {
        $discount = 0;
        $tools = [];

        foreach ($order->getItems() as $orderItem) {
            if ($orderItem->getProduct()->getCategory() === '1') {
                $tools[$orderItem->getProduct()->getId()] = $orderItem->getProduct();
            }
        }

        if (count($tools) >= 2) {
            usort($tools, fn($a, $b) => $a->getPrice() <=> $b->getPrice());
            $this->reasons[] = '20% discount on the cheapest product when buying two or more Tools';
            $discount = $tools[0]->getPrice() * 0.20;
        }

        return round($discount, 2);
    }

    public function getDiscountReasons(): array
    {
        return $this->reasons;
    }
}
