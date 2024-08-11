<?php

namespace DiscountAPI\Domain\Repository;

use DiscountAPI\Domain\Entity\Product;

interface ProductRepositoryInterface
{
    public function findById(string $id): ?Product;
}