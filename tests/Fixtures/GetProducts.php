<?php

namespace OpenSolid\Tests\Cqs\Fixtures;

use OpenSolid\Cqs\Query\Query;

/**
 * @template-implements Query<array<string>>
 *
 * @psalm-immutable
 */
readonly class GetProducts implements Query
{
    public function __construct()
    {
    }
}
