<?php

namespace Cqs\Messenger;

use Cqs\Messenger\Middleware\MiddlewareStack;

readonly class NativeMessageBus implements MessageBus
{
    public function __construct(private MiddlewareStack $middlewares)
    {
    }

    public function dispatch(Message $message): mixed
    {
        $envelop = Envelop::wrap($message);

        $this->middlewares->handle($envelop);

        return $envelop->result;
    }
}
