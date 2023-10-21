<?php

namespace Yceruto\Cqs\Tests\Query;

use PHPUnit\Framework\TestCase;
use Yceruto\Cqs\Query\InMemoryQueryBus;
use Yceruto\Cqs\Tests\Query\Fixtures\GetProducts;
use Yceruto\Cqs\Tests\Query\Fixtures\GetProductsHandler;

class InMemoryQueryBusTest extends TestCase
{
    public function testAskQuery(): void
    {
        $queryBus = new InMemoryQueryBus([
            GetProducts::class => new GetProductsHandler(),
        ]);

        $this->assertSame(['P1', 'P2'], $queryBus->ask(new GetProducts()));
    }
}
