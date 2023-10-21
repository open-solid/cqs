<?php

namespace Yceruto\Cqs\Query;

use Yceruto\Cqs\Middleware\Envelop;
use Yceruto\Cqs\Middleware\HandlerNotFound;
use Yceruto\Cqs\Middleware\MiddlewareStack;

readonly class NativeQueryBus implements QueryBus
{
    public function __construct(private MiddlewareStack $stack)
    {
    }

    public function ask(object $object): mixed
    {
        $envelop = Envelop::wrap($object);

        try {
            $this->stack->handle($envelop);

            return $envelop->result;
        } catch (HandlerNotFound $e) {
            throw QueryHandlerNotFound::from($object, $e);
        }
    }
}
