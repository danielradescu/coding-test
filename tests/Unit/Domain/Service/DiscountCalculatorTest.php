<?php

namespace Tests\Unit\Domain\Service;

use DiscountAPI\Domain\Service\Discount\{CategorySwitchesDiscount, CategoryToolsDiscount, TotalPurchaseDiscount};
use DiscountAPI\Domain\Entity\Order;
use DiscountAPI\Domain\Factory\DiscountStrategyFactoryInterface;
use DiscountAPI\Domain\Service\DiscountCalculator;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class DiscountCalculatorTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testCalculateTotalDiscount()
    {
        $order = $this->createMock(Order::class);

        $switchesDiscount = $this->createMock(CategorySwitchesDiscount::class);
        $toolsDiscount = $this->createMock(CategoryToolsDiscount::class);
        $totalPurchaseDiscount = $this->createMock(TotalPurchaseDiscount::class);

        $switchesDiscount->method('calculateDiscount')
            ->willReturn(10.0);
        $toolsDiscount->method('calculateDiscount')
            ->willReturn(5.0);
        $totalPurchaseDiscount->method('calculateDiscount')
            ->willReturn(20.0);

        $strategyFactory = $this->createMock(DiscountStrategyFactoryInterface::class);
        $strategyFactory->method('createStrategies')
            ->willReturn([$switchesDiscount, $toolsDiscount, $totalPurchaseDiscount]);

        $calculator = new DiscountCalculator($strategyFactory);

        $discount = $calculator->calculate($order);

        $this->assertEquals(35, $discount->getDiscount()->getAmount());
        $this->assertCount(3, $discount->getAppliedDiscounts());
    }
}