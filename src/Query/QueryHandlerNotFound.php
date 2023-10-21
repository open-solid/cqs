<?php

namespace Yceruto\Cqs\Query;

use Ddd\Domain\Error\DomainError;

class QueryHandlerNotFound extends DomainError
{
    protected const DEFAULT_MESSAGE = 'Query handler not found.';

    public static function from(string $class): static
    {
        return new static(sprintf('Query handler not found for "%s"', $class));
    }
}
