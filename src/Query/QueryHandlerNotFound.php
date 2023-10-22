<?php

namespace Cqs\Query;

class QueryHandlerNotFound extends \LogicException
{
    public static function from(Query $query, \Throwable $previous = null): self
    {
        return new self(sprintf('Query handler not found for query "%s".', get_class($query)), 0, $previous);
    }
}
