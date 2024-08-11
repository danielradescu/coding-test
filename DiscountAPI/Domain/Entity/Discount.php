<?php

namespace DiscountAPI\Domain\Entity;

use DiscountAPI\Domain\ValueObject\Money;
use \DiscountAPI\Domain\ValueObject\Discount as DiscountVO;
class Discount
{

    private DiscountVO $totalDiscount;
    private array $appliedDiscounts = [];

    public function __construct(private readonly Money $totalOrder)
    {
        $this->totalDiscount = new DiscountVO(0, []);
    }

    public function add(DiscountVO $discountVO): void
    {
        $this->appliedDiscounts[] = $discountVO;
        $this->totalDiscount = $this->totalDiscount->add($discountVO);
    }

    public function getDiscount(): DiscountVO
    {
        return $this->totalDiscount;
    }

    public function getPercentage(): float
    {
        return round(($this->totalDiscount->getAmount() / $this->totalOrder->getAmount()) * 100, 2);
    }

    public function getTotal(): Money
    {
        return $this->totalOrder;
    }

    public function getAppliedDiscounts(): array
    {
        return $this->appliedDiscounts;
    }
}