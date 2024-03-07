<?php

namespace OpenSolid\Tests\Cqs\Query;

use OpenSolid\Cqs\Query\Error\NoHandlerForQuery;
use OpenSolid\Cqs\Query\NativeQueryBus;
use OpenSolid\Messenger\Bus\NativeMessageBus;
use OpenSolid\Messenger\Handler\HandlersLocator;
use OpenSolid\Messenger\Middleware\HandleMessageMiddleware;
use OpenSolid\Tests\Cqs\Fixtures\GetProducts;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

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
        $this->expectExceptionMessage('No handler for query "OpenSolid\Tests\Cqs\Fixtures\GetProducts".');

        $handlerLocator = $this->createMock(ContainerInterface::class);
        $queryBus = new NativeQueryBus(new NativeMessageBus([new HandleMessageMiddleware($handlerLocator)]));

        $queryBus->ask(new GetProducts());
    }
}
