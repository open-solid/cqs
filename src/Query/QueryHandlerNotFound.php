<?php

namespace Yceruto\Cqs\Query;

use Ddd\Domain\Error\DomainError;

class QueryHandlerNotFound extends DomainError
{
    protected const DEFAULT_MESSAGE = 'Query handler not found.';

    public static function from(object $object, \Throwable $previous = null): static
    {
        return new static(sprintf('Query handler not found for query "%s".', get_class($object)), 0, $previous);
    }
}
