<?php

namespace OpenSolid\Cqs\Query;

use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class SymfonyQueryBus implements QueryBus
{
    use HandleTrait;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    /**
     * {@inheritdoc}
     */
    public function ask(Query $query): mixed
    {
        try {
            return $this->handle($query);
        } catch (NoHandlerForMessageException) {
            throw NoHandlerForQuery::from($query);
        } catch (HandlerFailedException $error) {
            throw $error->getPrevious() ?? $error;
        }
    }
}
