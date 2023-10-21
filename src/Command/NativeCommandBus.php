<?php

namespace Yceruto\Cqs\Command;

use Yceruto\Cqs\Middleware\Envelop;
use Yceruto\Cqs\Middleware\HandlerNotFound;
use Yceruto\Cqs\Middleware\MiddlewareStack;

readonly class NativeCommandBus implements CommandBus
{
    public function __construct(private MiddlewareStack $stack)
    {
    }

    public function execute(object $object): mixed
    {
        $envelop = Envelop::wrap($object);

        try {
            $this->stack->handle($envelop);

            return $envelop->result;
        } catch (HandlerNotFound $e) {
            throw CommandHandlerNotFound::from($object, $e);
        }
    }
}
