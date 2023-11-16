<?php

namespace Tests\Cqs\Fixtures;

use Cqs\Query\Query;

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
