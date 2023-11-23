<?php

namespace OpenSolid\Tests\Cqs\Fixtures;

use OpenSolid\Cqs\Command\Command;

/**
 * @template-implements Command<null>
 *
 * @psalm-immutable
 */
readonly class CreateProduct implements Command
{
    public function __construct()
    {
    }
}
