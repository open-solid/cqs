<?php

namespace Cqs\Tests\Messenger;

use Cqs\Messenger\Middleware\HandlerMiddleware;
use Cqs\Messenger\Middleware\MiddlewareChain;
use Cqs\Messenger\NativeMessageBus;
use Cqs\Tests\Fixtures\CreateProduct;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Symfony\Contracts\Service\ServiceLocatorTrait;

class NativeMessageBusTest extends TestCase
{
    public function testDispatch(): void
    {
        $factories = [
            CreateProduct::class => static fn (): callable => static fn (CreateProduct $command) => $command,
        ];
        /** @psalm-suppress PropertyNotSetInConstructor */
        $handlerLocator = new class($factories) implements ContainerInterface {
            use ServiceLocatorTrait;
        };
        $handlerMiddleware = new HandlerMiddleware($handlerLocator);
        $bus = new NativeMessageBus(new MiddlewareChain([$handlerMiddleware]));
        $message = new CreateProduct();

        $this->assertSame($message, $bus->dispatch($message));
    }
}
