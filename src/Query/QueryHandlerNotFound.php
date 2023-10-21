<?php

namespace Cqs\Query;

use Ddd\Domain\Error\DomainError;

class QueryHandlerNotFound extends DomainError
{
    protected const DEFAULT_MESSAGE = 'Query handler not found.';

    public static function from(Query $query, \Throwable $previous = null): static
    {
        return new static(sprintf('Query handler not found for query "%s".', get_class($query)), 0, $previous);
    }
}
