<?php

namespace Cqs\Query;

use Cqs\Messenger\HandlerNotFound;
use Cqs\Messenger\MessageBus;

readonly class NativeQueryBus implements QueryBus
{
    public function __construct(private MessageBus $messageBus)
    {
    }

    public function ask(Query $query): mixed
    {
        try {
            return $this->messageBus->dispatch($query);
        } catch (HandlerNotFound $e) {
            throw QueryHandlerNotFound::from($query, $e);
        }
    }
}
