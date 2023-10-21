<?php

namespace Cqs\Command;

use Cqs\Middleware\Envelop;
use Cqs\Middleware\HandlerNotFound;
use Cqs\Middleware\Middlewares;

readonly class NativeCommandBus implements CommandBus
{
    public function __construct(private Middlewares $middlewares)
    {
    }

    public function execute(object $object): mixed
    {
        $envelop = Envelop::wrap($object);

        try {
            $this->middlewares->handle($envelop);

            return $envelop->result;
        } catch (HandlerNotFound $e) {
            throw CommandHandlerNotFound::from($object, $e);
        }
    }
}
