<?php

namespace Cqs\Tests\Fixtures;

use Cqs\Command\Command;

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
