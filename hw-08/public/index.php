<?php declare(strict_types=1);

use Books\Middleware\JsonBodyParserMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);
$app->add(new JsonBodyParserMiddleware());

$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write('Funguje to! Ale nic tady není.');
    return $response;
});

$app->get('/books', function (Request $request, Response $response, $args) {
    $payload = json_encode([]);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
