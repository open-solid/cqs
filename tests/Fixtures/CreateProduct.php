<?php

namespace Cqs\Tests\Fixtures;

use Cqs\Command\Command;

/**
 * @template-implements Command<null>
 */
readonly class CreateProduct implements Command
{
    public function __construct()
    {
    }
}
