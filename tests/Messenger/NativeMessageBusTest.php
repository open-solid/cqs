<?php

namespace Cqs\Tests\Messenger;

use Cqs\Messenger\Middleware\HandlerMiddleware;
use Cqs\Messenger\Middleware\MiddlewareChain;
use Cqs\Messenger\NativeMessageBus;
use Cqs\Tests\Command\Fixtures\CreateProduct;
use PHPUnit\Framework\TestCase;

class NativeMessageBusTest extends TestCase
{
    public function testDispatch(): void
    {
        $handlerMiddleware = new HandlerMiddleware([
            CreateProduct::class => static fn (CreateProduct $command) => $command,
        ]);
        $bus = new NativeMessageBus(new MiddlewareChain([$handlerMiddleware]));
        $message = new CreateProduct();

        $this->assertSame($message, $bus->dispatch($message));
    }
}
