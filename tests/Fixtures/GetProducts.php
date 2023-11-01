<?php

namespace Cqs\Tests\Fixtures;

use Cqs\Query\Query;

/**
 * @template-implements Query<array<string>>
 */
readonly class GetProducts implements Query
{
    public function __construct()
    {
    }
}
