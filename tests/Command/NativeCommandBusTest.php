<?php

namespace Tests\Cqs\Command;

use Cqs\Command\NoHandlerForCommand;
use Cqs\Command\NativeCommandBus;
use Tests\Cqs\Fixtures\CreateProduct;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Yceruto\Messenger\Bus\NativeMessageBus;
use Yceruto\Messenger\Handler\HandlersCountPolicy;
use Yceruto\Messenger\Handler\HandlersLocator;
use Yceruto\Messenger\Middleware\HandleMessageMiddleware;

class NativeCommandBusTest extends TestCase
{
    public function testExecuteCommand(): void
    {
        $command = new CreateProduct();
        /** @psalm-suppress UnusedClosureParam */
        $handler = function (CreateProduct $command): void {
            /** @psalm-suppress InternalMethod */
            $this->addToAssertionCount(1);
        };
        $handlerMiddleware = new HandleMessageMiddleware(new HandlersLocator([
            CreateProduct::class => [$handler],
        ]), HandlersCountPolicy::SINGLE_HANDLER);
        $commandBus = new NativeCommandBus(new NativeMessageBus([$handlerMiddleware]));

        $this->assertNull($commandBus->execute($command));
    }

    public function testNoHandlerForCommand(): void
    {
        $this->expectException(NoHandlerForCommand::class);
        $this->expectExceptionMessage('No handler for command "Tests\Cqs\Fixtures\CreateProduct".');

        $handlerLocator = $this->createMock(ContainerInterface::class);
        $commandBus = new NativeCommandBus(new NativeMessageBus([new HandleMessageMiddleware($handlerLocator)]));

        $commandBus->execute(new CreateProduct());
    }
}
