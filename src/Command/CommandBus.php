<?php

namespace Cqs\Command;

interface CommandBus
{
    public function execute(object $object): mixed;
}
