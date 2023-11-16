<?php

namespace Tests\Cqs\Query;

use Cqs\Query\NativeQueryBus;
use Cqs\Query\NoHandlerForQuery;
use Tests\Cqs\Fixtures\GetProducts;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Yceruto\Messenger\Bus\NativeMessageBus;
use Yceruto\Messenger\Handler\HandlersLocator;
use Yceruto\Messenger\Middleware\HandleMessageMiddleware;

class NativeQueryBusTest extends TestCase
{
    public function testAskQuery(): void
    {
        /** @psalm-suppress UnusedClosureParam */
        $handler = static fn(GetProducts $query): array => ['P1', 'P2'];
        $handlerMiddleware = new HandleMessageMiddleware(new HandlersLocator([
            GetProducts::class => [$handler],
        ]));
        $queryBus = new NativeQueryBus(new NativeMessageBus([$handlerMiddleware]));

        $this->assertSame(['P1', 'P2'], $queryBus->ask(new GetProducts()));
    }

    public function testNoHandlerForQuery(): void
    {
        $this->expectException(NoHandlerForQuery::class);
        $this->expectExceptionMessage('No handler for query "Tests\Cqs\Fixtures\GetProducts".');

        $handlerLocator = $this->createMock(ContainerInterface::class);
        $queryBus = new NativeQueryBus(new NativeMessageBus([new HandleMessageMiddleware($handlerLocator)]));

        $queryBus->ask(new GetProducts());
    }
}
