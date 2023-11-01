<?php

namespace Cqs\Command;

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
