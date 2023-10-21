<?php

namespace Cqs\Messenger\Middleware;

use Cqs\Messenger\Envelop;

interface MiddlewareStack
{
    public function handle(Envelop $envelop): void;
}
