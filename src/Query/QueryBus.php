<?php

namespace Cqs\Query;

interface QueryBus
{
    public function ask(object $object): mixed;
}
