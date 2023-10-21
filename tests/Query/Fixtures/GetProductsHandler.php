<?php

namespace Yceruto\Cqs\Tests\Query\Fixtures;

class GetProductsHandler
{
    public function __invoke(GetProducts $query): array
    {
        return ['P1', 'P2'];
    }
}
