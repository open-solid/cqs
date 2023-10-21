<?php

namespace Yceruto\Cqs\Command;

use Ddd\Domain\Error\DomainError;

class CommandHandlerNotFound extends DomainError
{
    protected const DEFAULT_MESSAGE = 'Command handler not found.';

    public static function from(string $class): static
    {
        return new static(sprintf('Command handler not found for "%s"', $class));
    }
}
