<?php

namespace Yceruto\Cqs\Tests\Query;

use PHPUnit\Framework\TestCase;
use Yceruto\Cqs\Middleware\HandlerMiddleware;
use Yceruto\Cqs\Middleware\MiddlewareChain;
use Yceruto\Cqs\Query\NativeQueryBus;
use Yceruto\Cqs\Tests\Query\Fixtures\GetProducts;

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
