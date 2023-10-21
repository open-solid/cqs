<?php

namespace Yceruto\Cqs\Middleware;

use ArrayIterator;

readonly class MiddlewareChain implements MiddlewareStack
{
    /**
     * @param list<Middleware> $middlewares
     */
    public function __construct(private array $middlewares)
    {
    }

    public function handle(Envelop $envelop): void
    {
        $next = static fn (): null => null;

        foreach (array_reverse($this->middlewares) as $middleware) {
            $next = static fn (Envelop $envelop): null => $middleware->handle($envelop, $next);
        }

        $next($envelop);
    }
}
