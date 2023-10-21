<?php

namespace Yceruto\Cqs\Query;

use Ddd\Domain\Error\DomainError;

class QueryHandlerNotFound extends DomainError
{
    protected const DEFAULT_MESSAGE = 'Query handler not found.';

    public static function from(string $class): self
    {
        return self::create(sprintf('Query handler not found for "%s"', $class));
    }
}
