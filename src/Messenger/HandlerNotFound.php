<?php

namespace Cqs\Messenger;

use Ddd\Domain\Error\DomainError;

class HandlerNotFound extends DomainError
{
    protected const DEFAULT_MESSAGE = 'Message handler not found.';

    public static function from(string $class): static
    {
        return new static(sprintf('Handler not found for message "%s"', $class));
    }
}
