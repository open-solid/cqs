<?php

namespace Cqs\Tests\Command;

use Cqs\Command\CommandHandlerNotFound;
use Cqs\Command\NativeCommandBus;
use Cqs\Messenger\Middleware\HandlerMiddleware;
use Cqs\Messenger\Middleware\MiddlewareChain;
use Cqs\Messenger\NativeMessageBus;
use Cqs\Tests\Fixtures\CreateProduct;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Symfony\Contracts\Service\ServiceLocatorTrait;

class NativeCommandBusTest extends TestCase
{
    public function testExecuteCommand(): void
    {
        $tester = $this;
        $command = new CreateProduct();
        $factories = [
            CreateProduct::class => static fn (): callable => new class($tester) {
                public function __construct(private readonly TestCase $tester)
                {
                }

                public function __invoke(CreateProduct $command): void
                {
                    /** @psalm-suppress InternalMethod */
                    $this->tester->addToAssertionCount(1);
                }
            },
        ];
        /** @psalm-suppress PropertyNotSetInConstructor */
        $handlerLocator = new class($factories) implements ContainerInterface {
            use ServiceLocatorTrait;
        };
        $handlerMiddleware = new HandlerMiddleware($handlerLocator);
        $commandBus = new NativeCommandBus(new NativeMessageBus(new MiddlewareChain([$handlerMiddleware])));

        $this->assertNull($commandBus->execute($command));
    }

    public function testCommandHandlerNotFound(): void
    {
        $this->expectException(CommandHandlerNotFound::class);
        $this->expectExceptionMessage('Command handler not found for command "Cqs\Tests\Fixtures\CreateProduct".');

        $handlerLocator = $this->createMock(ContainerInterface::class);
        $commandBus = new NativeCommandBus(new NativeMessageBus(new MiddlewareChain([new HandlerMiddleware($handlerLocator)])));

        $commandBus->execute(new CreateProduct());
    }
}
