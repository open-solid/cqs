<?php

namespace Yceruto\Cqs\Tests\Query;

use PHPUnit\Framework\TestCase;
use Yceruto\Cqs\Query\InMemoryQueryAsker;
use Yceruto\Cqs\Tests\Query\Fixtures\GetProducts;
use Yceruto\Cqs\Tests\Query\Fixtures\GetProductsHandler;

class InMemoryQueryAskerTest extends TestCase
{
    public function testAskQuery(): void
    {
        $queryAsker = new InMemoryQueryAsker([
            GetProducts::class => new GetProductsHandler(),
        ]);

        $this->assertSame(['P1', 'P2'], $queryAsker->ask(new GetProducts()));
    }
}
