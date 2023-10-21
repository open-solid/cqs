<?php

namespace Cqs\Command;

use Ddd\Domain\Error\DomainError;

class CommandHandlerNotFound extends DomainError
{
    protected const DEFAULT_MESSAGE = 'Command handler not found.';

    public static function from(object $object, \Throwable $previous = null): static
    {
        return new static(sprintf('Command handler not found for command "%s".', get_class($object)), 0, $previous);
    }
}
