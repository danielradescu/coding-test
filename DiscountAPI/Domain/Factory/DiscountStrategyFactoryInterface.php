<?php

namespace DiscountAPI\Domain\Factory;

use DiscountAPI\Domain\Service\DiscountStrategy;

interface DiscountStrategyFactoryInterface
{
    /**
     * Creates and returns an array of discount strategies.
     *
     * @return DiscountStrategy[]
     */
    public function createStrategies(): array;
}