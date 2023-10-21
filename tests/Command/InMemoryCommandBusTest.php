<?php

namespace Yceruto\Cqs\Tests\Command;

use PHPUnit\Framework\TestCase;
use Yceruto\Cqs\Command\InMemoryCommandBus;
use Yceruto\Cqs\Tests\Command\Fixtures\CreateProduct;
use Yceruto\Cqs\Tests\Command\Fixtures\CreateProductHandler;

class InMemoryCommandBusTest extends TestCase
{
    public function testExecuteCommand(): void
    {
        $command = new CreateProduct();
        $handler = $this->createMock(CreateProductHandler::class);
        $handler->expects($this->once())
            ->method('__invoke')
            ->with($command)
        ;
        $commandBus = new InMemoryCommandBus([
            CreateProduct::class => $handler,
        ]);

        $commandBus->execute($command);
    }
}
