<?php

namespace Cqs\Command;

class CommandHandlerNotFound extends \LogicException
{
    public static function from(Command $command, \Throwable $previous = null): self
    {
        return new self(sprintf('Command handler not found for command "%s".', get_class($command)), 0, $previous);
    }
}
