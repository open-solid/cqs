<?php

namespace Yceruto\Cqs\Tests\Command;

use PHPUnit\Framework\TestCase;
use Yceruto\Cqs\Command\InMemoryCommandExecutor;
use Yceruto\Cqs\Tests\Command\Fixtures\CreateProduct;
use Yceruto\Cqs\Tests\Command\Fixtures\CreateProductHandler;

class InMemoryCommandExecutorTest extends TestCase
{
    public function testExecuteCommand(): void
    {
        $command = new CreateProduct();
        $handler = $this->createMock(CreateProductHandler::class);
        $handler->expects($this->once())
            ->method('__invoke')
            ->with($command)
        ;

        $commandExecutor = new InMemoryCommandExecutor([
            CreateProduct::class => $handler,
        ]);

        $commandExecutor->execute($command);
    }
}
