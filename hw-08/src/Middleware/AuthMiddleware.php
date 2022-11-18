<?php declare(strict_types=1);

namespace Books\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class AuthMiddleware implements MiddlewareInterface
{
    public function process(Request $request, RequestHandler $handler): Response
    {
        // Return 401 if Authorization header is missing
        if (!$request->hasHeader("Authorization"))
        {
            $resp = new \Slim\Psr7\Response();
            return $resp->withStatus(401);
        }

        // Get Authorization header content
        $auth = $request->getHeaderLine("Authorization");
        $keyword = explode(" ", $auth)[0];

        // Check Authorization type
        if ($keyword !== "Basic")
        {
            $resp = new \Slim\Psr7\Response();
            return $resp->withStatus(401);
        }

        // Extract data from base64-encoded token
        $hash = explode(" ", $auth)[1];
        $hash = base64_decode($hash);

        $username = explode(":", $hash)[0];
        $password = explode(":", $hash)[1];


        // Validate data
        if (!($username === "admin" && $password === 'pas$word'))
        {
            $resp = new \Slim\Psr7\Response();
            return $resp->withStatus(401);
        }

        return $handler->handle($request);
    }
}