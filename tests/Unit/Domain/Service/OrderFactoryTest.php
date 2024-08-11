<?php

namespace Tests\Unit\Domain\Service;

use Exception;
use PHPUnit\Framework\TestCase;
use DiscountAPI\Domain\Service\OrderFactory;
use DiscountAPI\Domain\Entity\Order;
use DiscountAPI\Domain\Entity\OrderItem;

class OrderFactoryTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testCreateOrder()
    {
        $orderData = [
            'id' => '123',
            "customer-id" => "1",
            'items' => [
                ['product-id' => 'A101', 'quantity' => 2],
                ['product-id' => 'B102', 'quantity' => 1],
            ],
        ];

        $factory = new OrderFactory();
        $order = $factory->createOrder($orderData);

        $this->assertInstanceOf(Order::class, $order);
        $this->assertCount(2, $order->getItems());
        $this->assertEquals(24.49, $order->getTotal()->getAmount());
    }
}