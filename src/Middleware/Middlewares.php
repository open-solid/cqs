<?php

namespace Cqs\Middleware;

interface Middlewares
{
    public function handle(Envelop $envelop): void;
}
