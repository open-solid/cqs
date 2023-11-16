<?php

namespace Cqs\Query;

use Yceruto\Messenger\Bus\MessageBus;
use Yceruto\Messenger\Error\NoHandlerForMessage;

readonly class NativeQueryBus implements QueryBus
{
    public function __construct(private MessageBus $messageBus)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function ask(Query $query): mixed
    {
        try {
            return $this->messageBus->dispatch($query);
        } catch (NoHandlerForMessage $e) {
            throw NoHandlerForQuery::from($query, $e);
        }
    }
}
