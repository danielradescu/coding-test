<?php

namespace DiscountAPI\Domain\Service;

use DiscountAPI\Domain\Entity\Product;
use DiscountAPI\Domain\Repository\ProductRepositoryInterface;
use Exception;

readonly class ProductService
{
    public function __construct(private ProductRepositoryInterface $productRepository)
    {
    }

    /**
     * @throws Exception
     */
    public function getProductById(string $id): ?Product
    {
        try {
            $product = $this->productRepository->findById($id);
            if ($product === null) {
                throw new Exception("Product with ID $id not found");
            }
            return $product;
        } catch (Exception $e) {
            throw new Exception("Failed to retrieve product: " . $e->getMessage());
        }
    }

}
