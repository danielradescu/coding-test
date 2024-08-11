<?php

namespace DiscountAPI\Domain\Entity;

class Customer
{
    public function __construct(
        public string $id,
        public string $name,
        public string $since,
        public float  $revenue
    )
    {
    }

    // Getters for each property
    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSince(): string
    {
        return $this->since;
    }

    public function getRevenue(): float
    {
        return $this->revenue;
    }
}