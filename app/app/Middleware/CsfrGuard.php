<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Exceptions\CsfrTokenException;
use App\Security\Csfr;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CsfrGuard implements MiddlewareInterface
{
    public function __construct(protected Csfr $csrf)
    {
    }

    /** @throws CsfrTokenException */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!$this->requestRequiresProtection($request)) {
            return $handler->handle($request);
        }

        if (!$this->csrf->tokenIsValid($this->getTokenFromRequest($request))) {
            throw new CsfrTokenException();
        }

        return $handler->handle($request);
    }

    protected function getTokenFromRequest(ServerRequestInterface $request): ?string
    {
        return $request->getParsedBody()[$this->csrf::SESSION_KEY] ?? null;
    }

    protected function requestRequiresProtection(ServerRequestInterface $request): bool
    {
        return in_array($request->getMethod(), ['POST', 'PUT', 'DELETE', 'PATCH']);
    }
}