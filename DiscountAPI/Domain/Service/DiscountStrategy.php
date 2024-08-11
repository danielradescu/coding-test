<?php

namespace DiscountAPI\Domain\Service;

use DiscountAPI\Domain\Entity\Discount;
use DiscountAPI\Domain\Entity\DiscountableOrder;

interface DiscountStrategy
{
    public function calculate(DiscountableOrder $order): Discount;
}