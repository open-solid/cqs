<?php

namespace Yceruto\Cqs\Command;

interface CommandExecutor
{
    public function execute(object $object): void;
}
