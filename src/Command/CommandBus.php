<?php

declare(strict_types=1);

namespace OpenSolid\Cqs\Command;

interface CommandBus
{
    /**
     * @template T
     *
     * @param Command<T> $command
     *
     * @return T
     */
    public function execute(Command $command): mixed;
}
