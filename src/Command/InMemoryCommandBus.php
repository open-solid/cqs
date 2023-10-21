<?php

namespace Yceruto\Cqs\Command;

readonly class InMemoryCommandBus implements CommandBus
{
    /**
     * @param array<class-string, callable> $commandHandlers
     */
    public function __construct(private array $commandHandlers)
    {
    }

    public function execute(object $object): void
    {
        $class = get_class($object);

        if (null === $commandHandler = $this->commandHandlers[$class] ?? null) {
            throw CommandHandlerNotFound::from($class);
        }

        if (!is_callable($commandHandler)) {
            throw CommandHandlerNotFound::from($class);
        }

        $commandHandler($object);
    }
}
