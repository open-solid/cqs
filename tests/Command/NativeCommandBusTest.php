<?php

namespace OpenSolid\Tests\Cqs\Command;

use OpenSolid\Cqs\Command\NoHandlerForCommand;
use OpenSolid\Cqs\Command\NativeCommandBus;
use OpenSolid\Tests\Cqs\Fixtures\CreateProduct;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use OpenSolid\Messenger\Bus\NativeMessageBus;
use OpenSolid\Messenger\Handler\HandlersCountPolicy;
use OpenSolid\Messenger\Handler\HandlersLocator;
use OpenSolid\Messenger\Middleware\HandleMessageMiddleware;

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
        $this->expectExceptionMessage('No handler for command "OpenSolid\Tests\Cqs\Fixtures\CreateProduct".');

        $handlerLocator = $this->createMock(ContainerInterface::class);
        $commandBus = new NativeCommandBus(new NativeMessageBus([new HandleMessageMiddleware($handlerLocator)]));

        $commandBus->execute(new CreateProduct());
    }
}
