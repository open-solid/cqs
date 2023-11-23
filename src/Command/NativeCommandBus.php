<?php

namespace OpenSolid\Cqs\Command;

use OpenSolid\Messenger\Bus\MessageBus;
use OpenSolid\Messenger\Error\NoHandlerForMessage;

readonly class NativeCommandBus implements CommandBus
{
    public function __construct(private MessageBus $messageBus)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function execute(Command $command): mixed
    {
        try {
            return $this->messageBus->dispatch($command);
        } catch (NoHandlerForMessage $e) {
            throw NoHandlerForCommand::from($command, $e);
        }
    }
}
