<?php

namespace Cqs\Middleware;

readonly class HandlerMiddleware implements Middleware
{
    /**
     * @param array<class-string, callable> $handlers
     */
    public function __construct(private array $handlers)
    {
    }

    public function handle(Envelop $envelop, callable $next): void
    {
        $class = get_class($envelop->object);

        if (null === $handler = $this->handlers[$class] ?? null) {
            throw HandlerNotFound::from($class);
        }

        $envelop->result = $handler($envelop->object);

        $next($envelop);
    }
}
