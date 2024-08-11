<?php

namespace DiscountAPI\Application\Controller;

use DiscountAPI\Domain\Dto\DiscountDto;
use DiscountAPI\Domain\Service\DiscountStrategy;
use DiscountAPI\Domain\Service\OrderDiscount;
use DiscountAPI\Domain\Service\OrderFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

readonly class DiscountController
{

    public function __construct(
        private OrderFactory     $orderFactory,
        private DiscountStrategy $discountCalculator
    )
    {
    }

    public function create(Request $request, Response $response): Response
    {
        $orderData = json_decode($request->getBody()->getContents(), true);

        $order = $this->orderFactory->createOrder($orderData);

        $orderDiscountService = new OrderDiscount($order, $this->discountCalculator);
        $discount = $orderDiscountService->calculateDiscounts();

        $response->getBody()->write(json_encode(new DiscountDto($discount)));
        return $response->withHeader('Content-Type', 'application/json');
    }
}