<?php

namespace Cqs\Query;

interface QueryBus
{
    public function ask(Query $query): mixed;
}
