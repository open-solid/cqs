<?php

namespace Cqs\Middleware;

interface Middleware
{
    public function handle(Envelop $envelop, callable $next): void;
}
