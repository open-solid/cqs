<?php

namespace Cqs\Tests\Query;

use Cqs\Messenger\Middleware\HandlerMiddleware;
use Cqs\Messenger\Middleware\MiddlewareChain;
use Cqs\Messenger\NativeMessageBus;
use Cqs\Query\NativeQueryBus;
use Cqs\Tests\Fixtures\GetProducts;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Symfony\Contracts\Service\ServiceLocatorTrait;

class NativeQueryBusTest extends TestCase
{
    public function testAskQuery(): void
    {
        $factories = [
            GetProducts::class => static fn (): callable => new class() {
                public function __invoke(GetProducts $query): array
                {
                    return ['P1', 'P2'];
                }
            },
        ];
        /** @psalm-suppress PropertyNotSetInConstructor */
        $handlerLocator = new class($factories) implements ContainerInterface {
            use ServiceLocatorTrait;
        };
        $handlerMiddleware = new HandlerMiddleware($handlerLocator);
        $queryBus = new NativeQueryBus(new NativeMessageBus(new MiddlewareChain([$handlerMiddleware])));

        $this->assertSame(['P1', 'P2'], $queryBus->ask(new GetProducts()));
    }
}
