<?php

namespace Cqs\Messenger\Middleware;

use Cqs\Messenger\Envelop;
use Cqs\Messenger\HandlerNotFound;
use Psr\Container\ContainerInterface;

readonly class HandlerMiddleware implements Middleware
{
    public function __construct(private ContainerInterface $handlers)
    {
    }

    public function handle(Envelop $envelop, callable $next): void
    {
        $class = get_class($envelop->message);

        if (!$this->handlers->has($class)) {
            throw HandlerNotFound::from($class);
        }

        $handler = $this->handlers->get($class);
        $envelop->result = $handler($envelop->message);

        $next($envelop);
    }
}
