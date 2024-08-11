<?php

use DI\Container;
use DiscountAPI\Application\Controller\DiscountController;
use DiscountAPI\Domain\Factory\DiscountStrategyFactoryInterface;
use DiscountAPI\Domain\Service\DiscountCalculator;
use DiscountAPI\Domain\Service\OrderFactory;
use DiscountAPI\Infrastructure\Factory\DiscountStrategyFactory;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$container = new Container();

// Register DiscountCalculator with the strategies injected
$container->set(DiscountStrategyFactoryInterface::class, function (ContainerInterface $c) {
    return new DiscountCalculator(new DiscountStrategyFactory());
});

// Set up dependencies
$container->set(OrderFactory::class, function (ContainerInterface $c) {
    return new OrderFactory();
});
$container->set(DiscountController::class, function (ContainerInterface $c) {
    return new DiscountController($c->get(OrderFactory::class), $c->get(DiscountStrategyFactoryInterface::class));
});

// Create the app with the container
AppFactory::setContainer($container);
$app = AppFactory::create();

// Define routes
$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write("Forbidden");
    return $response->withStatus(403);
});
$app->post('/discount', [DiscountController::class, 'create']);

$app->run();