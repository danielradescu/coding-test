<?php

namespace DiscountAPI\Domain\Dto;

use DiscountAPI\Domain\Entity\Discount;
use DiscountAPI\Domain\ValueObject\Discount as DiscountVO;
use JsonSerializable;

final readonly class DiscountDto implements JsonSerializable
{
    public function __construct(
        public Discount $discount,
    )
    {
    }

    public function jsonSerialize(): array
    {
        return [
            'total-discount' => $this->discount->getDiscount()->getAmount(),
            'all-reasons' => $this->discount->getDiscount()->getReasons(),
            'total-percentage' => $this->discount->getPercentage(),
            'total-order' => $this->discount->getTotal()->getAmount(),
            'detail-discounts' => array_map(function(DiscountVO $discount) {
                return [
                    'amount' => $discount->getAmount(),
                    'reasons' => $discount->getReasons(),
                ];
            }, $this->discount->getAppliedDiscounts()),
        ];
    }
}