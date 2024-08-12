<?php

namespace DiscountAPI\Domain\Service;

use DiscountAPI\Application\Exception\UnprocessableEntityException;
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

        $product = $this->productRepository->findById($id);
        if ($product === null) {
            throw new UnprocessableEntityException("Product with ID $id not found");
        }
        return $product;
    }

}
