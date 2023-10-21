<?php

namespace Cqs\Tests\Query;

use Cqs\Messenger\Middleware\HandlerMiddleware;
use Cqs\Messenger\Middleware\MiddlewareChain;
use Cqs\Messenger\NativeMessageBus;
use Cqs\Query\NativeQueryBus;
use Cqs\Tests\Query\Fixtures\GetProducts;
use PHPUnit\Framework\TestCase;

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
        $queryBus = new NativeQueryBus(new NativeMessageBus(new MiddlewareChain([$handlerMiddleware])));

        $this->assertSame(['P1', 'P2'], $queryBus->ask(new GetProducts()));
    }
}
