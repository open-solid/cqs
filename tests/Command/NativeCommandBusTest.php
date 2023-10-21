<?php

namespace Cqs\Tests\Command;

use Cqs\Command\CommandHandlerNotFound;
use Cqs\Command\NativeCommandBus;
use Cqs\Middleware\HandlerMiddleware;
use Cqs\Middleware\MiddlewareChain;
use Cqs\Tests\Command\Fixtures\CreateProduct;
use PHPUnit\Framework\TestCase;

class NativeCommandBusTest extends TestCase
{
    public function testExecuteCommand(): void
    {
        $tester = $this;
        $command = new CreateProduct();
        $handlerMiddleware = new HandlerMiddleware([
            CreateProduct::class => new class($tester) {
                public function __construct(private readonly TestCase $tester)
                {
                }

                public function __invoke(CreateProduct $command): void
                {
                    /** @psalm-suppress InternalMethod */
                    $this->tester->addToAssertionCount(1);
                }
            },
        ]);
        $commandBus = new NativeCommandBus(new MiddlewareChain([$handlerMiddleware]));

        $this->assertNull($commandBus->execute($command));
    }

    public function testCommandHandlerNotFound(): void
    {
        $this->expectException(CommandHandlerNotFound::class);
        $this->expectExceptionMessage('Command handler not found for command "Cqs\Tests\Command\Fixtures\CreateProduct".');

        $commandBus = new NativeCommandBus(new MiddlewareChain([new HandlerMiddleware([])]));

        $commandBus->execute(new CreateProduct());
    }
}
