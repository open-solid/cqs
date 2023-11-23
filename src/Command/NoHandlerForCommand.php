<?php

namespace OpenSolid\Cqs\Command;

class NoHandlerForCommand extends \LogicException
{
    public static function from(Command $command, \Throwable $previous = null): self
    {
        return new self(sprintf('No handler for command "%s".', get_class($command)), 0, $previous);
    }
}
