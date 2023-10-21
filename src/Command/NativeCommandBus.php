<?php

namespace Cqs\Command;

use Cqs\Messenger\HandlerNotFound;
use Cqs\Messenger\MessageBus;

readonly class NativeCommandBus implements CommandBus
{
    public function __construct(private MessageBus $messageBus)
    {
    }

    public function execute(Command $command): mixed
    {
        try {
            return $this->messageBus->dispatch($command);
        } catch (HandlerNotFound $e) {
            throw CommandHandlerNotFound::from($command, $e);
        }
    }
}
