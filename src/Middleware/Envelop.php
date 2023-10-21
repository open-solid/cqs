<?php

namespace Yceruto\Cqs\Middleware;

final class Envelop
{
    public mixed $result = null;

    public static function wrap(object $object): self
    {
        return new self($object);
    }

    private function __construct(public readonly object $object)
    {
    }
}
