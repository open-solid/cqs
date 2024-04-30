<?php

declare(strict_types=1);

namespace OpenSolid\Cqs\Query;

use OpenSolid\Cqs\Query\Error\NoHandlerForQuery;
use OpenSolid\Messenger\Bus\MessageBus;
use OpenSolid\Messenger\Error\NoHandlerForMessage;

readonly class NativeQueryBus implements QueryBus
{
    public function __construct(
        private MessageBus $messageBus,
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function ask(Query $query): mixed
    {
        try {
            return $this->messageBus->dispatch($query);
        } catch (NoHandlerForMessage $e) {
            throw NoHandlerForQuery::create($query, $e);
        }
    }
}
