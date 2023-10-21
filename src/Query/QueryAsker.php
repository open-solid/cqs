<?php

namespace Yceruto\Cqs\Query;

interface QueryAsker
{
    public function ask(object $object): mixed;
}
