<?php

namespace Cqs\Query;

class NoHandlerForQuery extends \LogicException
{
    public static function from(Query $query, \Throwable $previous = null): self
    {
        return new self(sprintf('No handler for query "%s".', get_class($query)), 0, $previous);
    }
}
