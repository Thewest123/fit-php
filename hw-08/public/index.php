<?php declare(strict_types=1);

use Books\Middleware\JsonBodyParserMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

use Books\Model\Book;
use Books\Middleware\AuthMiddleware;
use Books\Middleware\TrailingSlashMiddleware;

require __DIR__ . '/../vendor/autoload.php';

Book::createTable();

$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);
$app->add(new JsonBodyParserMiddleware());
$app->add(new TrailingSlashMiddleware());

$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write('Funguje to! Ale nic tady není.');
    return $response;
});


/**
 * List all books
 */
$app->get('/books', function (Request $request, Response $response, $args) {

    $all = Book::all();
    $payload = json_encode(array_map(fn(Book $book): array => $book->toArraySimple(), $all));

    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

/**
 * Get book with id
 */
$app->get('/books/{bookId}', function (Request $request, Response $response, $args) {

    $book = Book::findById((int)$args['bookId']);
    if ($book === null) {
        return $response->withStatus(404);
    }

    $payload = json_encode($book->toArray());
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

/**
 * Create a new book
 */
$app->post('/books', function (Request $request, Response $response, $args): Response {
    $data = $request->getParsedBody();

    $errors = [];

    if (!isset($data['name']))
        $errors[] = "Missing field: name";

    if (!isset($data['author']))
        $errors[] = "Missing field: author";

    if (!isset($data['publisher']))
        $errors[] = "Missing field: publisher";

    if (!isset($data['isbn']))
        $errors[] = "Missing field: isbn";

    if (!isset($data['pages']))
        $errors[] = "Missing field: pages";

    if (count($errors) !== 0)
    {
        $response->getBody()->write(json_encode($errors));
        return $response->withStatus(400);
    }

    $book = new Book(
        null,
        $data["name"],
        $data["author"],
        $data["publisher"],
        $data["isbn"],
        intval($data["pages"])
    );

    $book->save();

    $payload = json_encode($book->toArray());
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json')->withStatus(201);

})->addMiddleware(new AuthMiddleware());

/**
 * Replace an existing book
 */
$app->put('/books/{bookId}', function (Request $request, Response $response, $args): Response {

    $book = Book::findById((int)$args['bookId']);
    if ($book === null) {
        return $response->withStatus(404);
    }

    $data = $request->getParsedBody();

    $errors = [];

    if (!isset($data['name']))
        $errors[] = "Missing field: name";

    if (!isset($data['author']))
        $errors[] = "Missing field: author";

    if (!isset($data['publisher']))
        $errors[] = "Missing field: publisher";

    if (!isset($data['isbn']))
        $errors[] = "Missing field: isbn";

    if (!isset($data['pages']))
        $errors[] = "Missing field: pages";

    if (count($errors) !== 0)
    {
        $response->getBody()->write(json_encode($errors));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);

    }

    $book->setName($data['name']);
    $book->setAuthor($data['author']);
    $book->setPublisher($data['publisher']);
    $book->setIsbn($data['isbn']);
    $book->setPages(intval($data['pages']));

    $book->save();

    return $response->withStatus(204);

})->addMiddleware(new AuthMiddleware());

/**
 * Update an existing book
 */
$app->patch('/books/{bookId}', function (Request $request, Response $response, $args): Response {

    $book = Book::findById((int)$args['bookId']);
    if ($book === null) {
        return $response->withStatus(404);
    }

    $data = $request->getParsedBody();

    if (isset($data['name']))
        $book->setName($data['name']);

    if (isset($data['author']))
        $book->setAuthor($data['author']);

    if (isset($data['publisher']))
        $book->setPublisher($data['publisher']);

    if (isset($data['isbn']))
        $book->setIsbn($data['isbn']);

    if (isset($data['pages']))
        $book->setPages(intval($data['pages']));

    $book->save();

    $payload = json_encode($book->toArray());
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json')->withStatus(201);

})->addMiddleware(new AuthMiddleware());

/**
 * Delete an existing book
 */
$app->delete('/books/{bookId}', function (Request $request, Response $response, $args): Response {

    $book = Book::findById((int)$args['bookId']);
    if ($book === null) {
        return $response->withStatus(404);
    }

    $book->delete();

    return $response->withStatus(204);

})->addMiddleware(new AuthMiddleware());

$app->run();
