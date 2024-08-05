<?php

declare(strict_types=1);

/*
 * This file is part of OpenSolid package.
 *
 * (c) Yonel Ceruto <open@yceruto.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSolid\Tests\Cqs\Query;

use OpenSolid\Bus\Handler\MessageHandlersLocator;
use OpenSolid\Bus\Middleware\HandlingMiddleware;
use OpenSolid\Bus\NativeMessageBus;
use OpenSolid\Cqs\Query\Error\NoHandlerForQuery;
use OpenSolid\Cqs\Query\NativeQueryBus;
use OpenSolid\Tests\Cqs\Fixtures\GetProducts;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class NativeQueryBusTest extends TestCase
{
    public function testAskQuery(): void
    {
        /** @psalm-suppress UnusedClosureParam */
        $handler = static fn (GetProducts $query): array => ['P1', 'P2'];
        $handlerMiddleware = new HandlingMiddleware(new MessageHandlersLocator([
            GetProducts::class => [$handler],
        ]));
        $queryBus = new NativeQueryBus(new NativeMessageBus([$handlerMiddleware]));

        $result = $queryBus->ask(new GetProducts());

        $this->assertSame(['P1', 'P2'], $result);
    }

    public function testNoHandlerForQuery(): void
    {
        $this->expectException(NoHandlerForQuery::class);
        $this->expectExceptionMessage('No handler for query of type "OpenSolid\Tests\Cqs\Fixtures\GetProducts".');

        $handlerLocator = $this->createMock(ContainerInterface::class);
        $queryBus = new NativeQueryBus(new NativeMessageBus([new HandlingMiddleware($handlerLocator)]));

        $queryBus->ask(new GetProducts());
    }
}
