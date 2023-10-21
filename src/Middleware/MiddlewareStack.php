<?php

namespace Yceruto\Cqs\Middleware;

interface MiddlewareStack
{
    public function handle(Envelop $envelop): void;
}
