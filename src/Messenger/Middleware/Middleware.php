<?php

namespace Cqs\Messenger\Middleware;

use Cqs\Messenger\Envelop;

interface Middleware
{
    public function handle(Envelop $envelop, callable $next): void;
}
