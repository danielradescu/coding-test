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
        if (empty($orderData['customer-id'])) {
            throw new \InvalidArgumentException('Customer ID is required.');
        }
        if (empty($orderData['id'])) {
            throw new \InvalidArgumentException('Order ID is required.');
        }

        $repositoryProducts = new JsonProductRepository($_ENV['PRODUCTS_JSON_PATH']);
        $productService = new ProductService($repositoryProducts);

        $items = [];
        $total = new Money();

        if (empty($orderData['items'])) {
            throw new \InvalidArgumentException('Order items are required required.');
        }

        foreach ($orderData['items'] as $orderItemData) {
            if (empty($orderItemData['product-id'])) {
                throw new \InvalidArgumentException('Order item product ID is required.');
            }
            $product = $productService->getProductById($orderItemData['product-id']);

            if (empty($orderItemData['quantity'])) {
                throw new \InvalidArgumentException('Order item quantity is required for ' . $product->getId());
            }
            $orderItem = new OrderItem(
                $product,
                (int)$orderItemData['quantity'],
                $product->getPrice(),
                new Money($product->getPrice() * $orderItemData['quantity'])
            );
            $items[] = $orderItem;
            $total = $total->add($orderItem->getTotal());
        }

        $repository = new JsonCustomerRepository($_ENV['CUSTOMERS_JSON_PATH']);
        $customerService = new CustomerService($repository);
        $customer = $customerService->getCustomerById($orderData['customer-id']);
        if (!$customer) {
            throw new \InvalidArgumentException('Invalid Customer ID.');
        }

        return new Order(
            $orderData['id'],
            $customer,
            $items,
            $total
        );
    }
}