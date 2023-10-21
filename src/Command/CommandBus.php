<?php

namespace Cqs\Command;

interface CommandBus
{
    public function execute(Command $command): mixed;
}
