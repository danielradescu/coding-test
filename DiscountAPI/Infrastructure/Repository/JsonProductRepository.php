<?php

namespace DiscountAPI\Infrastructure\Repository;

use DiscountAPI\Domain\Entity\Product;
use DiscountAPI\Domain\Repository\ProductRepositoryInterface;
use RuntimeException;

class JsonProductRepository implements ProductRepositoryInterface
{
    private string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function findById(string $id): ?Product
    {
        $products = $this->loadData();

        foreach ($products as $productData) {
            if ($productData['id'] === $id) {
                return $this->mapToProduct($productData);
            }
        }

        return null;
    }

    private function loadData(): array
    {
        if (!file_exists($this->filePath)) {
            throw new RuntimeException("JSON file not found: " . $this->filePath);
        }

        $json = file_get_contents($this->filePath);
        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException("Invalid JSON format: " . json_last_error_msg());
        }

        return $data;
    }

    private function mapToProduct(array $data): Product
    {
        return new Product(
            $data['id'],
            $data['description'],
            $data['category'],
            (float)$data['price']
        );
    }
}
