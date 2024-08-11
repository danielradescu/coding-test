<?php

namespace DiscountAPI\Domain\Service;

use DiscountAPI\Domain\Entity\DiscountableOrder;
use DiscountAPI\Domain\Entity\Order;
use DiscountAPI\Domain\Entity\OrderItem;
use DiscountAPI\Domain\ValueObject\Money;
use DiscountAPI\Infrastructure\Repository\JsonCustomerRepository;
use DiscountAPI\Infrastructure\Repository\JsonProductRepository;
use Exception;

class OrderFactory
{
    /**
     * @throws Exception
     */
    public function createOrder(array $orderData): DiscountableOrder
    {

        $repositoryProducts = new JsonProductRepository($_ENV['PRODUCTS_JSON_PATH']);
        $productService = new ProductService($repositoryProducts);

        $items = [];
        $total = new Money();

        foreach ($orderData['items'] as $orderItemData) {
            $product = $productService->getProductById($orderItemData['product-id']);
            $orderItem = new OrderItem(
                $product,
                (int)$orderItemData['quantity'],
                (float)$orderItemData['unit-price'],
                new Money($product->getPrice() * $orderItemData['quantity'])
            );
            $items[] = $orderItem;
            $total = $total->add($orderItem->getTotal());
        }

        $repository = new JsonCustomerRepository($_ENV['CUSTOMERS_JSON_PATH']);
        $customerService = new CustomerService($repository);
        $customer = $customerService->getCustomerById($orderData['customer-id']);

        return new Order(
            $orderData['id'],
            $customer,
            $items,
            $total
        );
    }
}