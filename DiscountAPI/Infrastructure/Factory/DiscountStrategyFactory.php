<?php

namespace DiscountAPI\Infrastructure\Factory;

use DiscountAPI\Domain\Factory\DiscountStrategyFactoryInterface;
use DiscountAPI\Domain\Service\Discount\{CategorySwitchesDiscount, CategoryToolsDiscount, TotalPurchaseDiscount};
use Exception;

class DiscountStrategyFactory implements DiscountStrategyFactoryInterface
{
    /**
     * @throws Exception
     */
    public function createStrategies(): array
    {
        // Instantiate the strategies dynamically
        try {
            return [
                new CategorySwitchesDiscount(),
                new CategoryToolsDiscount(),
                new TotalPurchaseDiscount(),
            ];
        } catch (Exception $e) {
            throw new Exception("Failed to create discount strategies: " . $e->getMessage());
        }
    }
}