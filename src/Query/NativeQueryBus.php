<?php

namespace Cqs\Query;

use Cqs\Middleware\Envelop;
use Cqs\Middleware\HandlerNotFound;
use Cqs\Middleware\Middlewares;

readonly class NativeQueryBus implements QueryBus
{
    public function __construct(private Middlewares $middlewares)
    {
    }

    public function ask(object $object): mixed
    {
        $envelop = Envelop::wrap($object);

        try {
            $this->middlewares->handle($envelop);

            return $envelop->result;
        } catch (HandlerNotFound $e) {
            throw QueryHandlerNotFound::from($object, $e);
        }
    }
}
