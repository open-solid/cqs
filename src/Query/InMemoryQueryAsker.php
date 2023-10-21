<?php

namespace Yceruto\Cqs\Query;

readonly class InMemoryQueryAsker implements QueryAsker
{
    /**
     * @param array<class-string, callable> $queryHandlers
     */
    public function __construct(private array $queryHandlers)
    {
    }

    public function ask(object $object): mixed
    {
        $class = get_class($object);

        if (null === $queryHandler = $this->queryHandlers[$class] ?? null) {
            throw QueryHandlerNotFound::from($class);
        }

        if (!is_callable($queryHandler)) {
            throw QueryHandlerNotFound::from($class);
        }

        return $queryHandler($object);
    }
}
