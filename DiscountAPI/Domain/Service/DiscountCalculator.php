<?php

namespace DiscountAPI\Domain\Service;

use DiscountAPI\Domain\Entity\Discount;
use DiscountAPI\Domain\Entity\DiscountableOrder;
use DiscountAPI\Domain\Factory\DiscountStrategyFactoryInterface;
use DiscountAPI\Domain\ValueObject\Discount as DiscountVO;

readonly class DiscountCalculator implements DiscountStrategy
{
    public function __construct(private DiscountStrategyFactoryInterface $strategyFactory)
    {
    }

    public function calculate(DiscountableOrder $order): Discount
    {

        $discountServices = $this->strategyFactory->createStrategies();
        $discount = new Discount($order->getTotal());

        foreach ($discountServices as $service) {
            $discountValue = $service->calculateDiscount($order);
            if ($discountValue > 0) {
                $discount->add(new DiscountVO($discountValue, $service->getDiscountReasons()));
            }
        }

        return $discount;
    }
}
