<?php

namespace DiscountAPI\Domain\Repository;


use DiscountAPI\Domain\Entity\Customer;

interface CustomerRepositoryInterface
{
    public function findById(string $id): ?Customer;

}