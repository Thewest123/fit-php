<?php
declare(strict_types = 1);

/**
 *
 * Inspired from
 * https://github.com/middlewares/trailing-slash/blob/master/src/TrailingSlash.php
 *
 */

namespace Books\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class TrailingSlashMiddleware implements MiddlewareInterface
{
    /**
     * Process a request and return a response.
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        $uri = $request->getUri();
        $path = $this->normalize($uri->getPath());

        return $handler->handle($request->withUri($uri->withPath($path)));
    }

    /**
     * Normalize the trailing slash.
     */
    private function normalize(string $path): string
    {
        if ($path === '')
            return '/';

        if (strlen($path) > 1)
            return rtrim($path, '/');

        return $path;
    }
}
