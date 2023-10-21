<?php

namespace Cqs\Tests\Query;

use PHPUnit\Framework\TestCase;
use Cqs\Middleware\HandlerMiddleware;
use Cqs\Middleware\MiddlewareChain;
use Cqs\Query\NativeQueryBus;
use Cqs\Tests\Query\Fixtures\GetProducts;

class NativeQueryBusTest extends TestCase
{
    public function testAskQuery(): void
    {
        $handlerMiddleware = new HandlerMiddleware([
            GetProducts::class => new class() {
                public function __invoke(GetProducts $query): array
                {
                    return ['P1', 'P2'];
                }
            },
        ]);
        $queryBus = new NativeQueryBus(new MiddlewareChain([$handlerMiddleware]));

        $this->assertSame(['P1', 'P2'], $queryBus->ask(new GetProducts()));
    }
}
