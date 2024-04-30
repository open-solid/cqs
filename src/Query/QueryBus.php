<?php

declare(strict_types=1);

namespace OpenSolid\Cqs\Query;

interface QueryBus
{
    /**
     * @template T
     *
     * @param Query<T> $query
     *
     * @return T
     */
    public function ask(Query $query): mixed;
}
