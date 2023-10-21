<?php

namespace Cqs\Middleware;

use Ddd\Domain\Error\DomainError;

class HandlerNotFound extends DomainError
{
    protected const DEFAULT_MESSAGE = 'Handler not found.';

    public static function from(string $class): static
    {
        return new static(sprintf('Handler not found for "%s"', $class));
    }
}
