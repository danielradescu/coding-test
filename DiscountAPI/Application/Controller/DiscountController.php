<?php

namespace DiscountAPI\Application\Controller;

use DiscountAPI\Application\Exception\UnprocessableEntityException;
use DiscountAPI\Domain\Dto\DiscountDto;
use DiscountAPI\Domain\Service\DiscountStrategy;
use DiscountAPI\Domain\Service\OrderDiscount;
use DiscountAPI\Domain\Service\OrderFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Exception;
use InvalidArgumentException;

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
        try {

            $orderData = json_decode($request->getBody()->getContents(), true);
            if (empty($orderData)) {
                throw new InvalidArgumentException('Invalid order data provided.');
            }

            $order = $this->orderFactory->createOrder($orderData);

            $orderDiscountService = new OrderDiscount($order, $this->discountCalculator);
            $discount = $orderDiscountService->calculateDiscounts();

            $response->getBody()->write(json_encode(new DiscountDto($discount)));
            return $response->withHeader('Content-Type', 'application/json');


        } catch (UnprocessableEntityException $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withStatus(422)->withHeader('Content-Type', 'application/json');
        } catch (InvalidArgumentException $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        } catch (Exception $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }
}