<?php

namespace Yceruto\Cqs\Command;

interface CommandBus
{
    public function execute(object $object): void;
}
