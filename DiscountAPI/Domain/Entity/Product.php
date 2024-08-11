<?php

namespace DiscountAPI\Domain\Entity;

class Product
{
    public function __construct(
        private readonly string $id,
        private readonly string $description,
        private readonly string $category,
        private readonly float  $price
    )
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}