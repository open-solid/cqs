<?php

namespace OpenSolid\Tests\Cqs\Command\Bridge;

use OpenSolid\Cqs\Command\Bridge\SymfonyCommandBus;
use OpenSolid\Tests\Cqs\Fixtures\CreateProduct;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Messenger\Stamp\SentStamp;

class SymfonyCommandBusTest extends TestCase
{
    public function testExecute(): void
    {
        $command = new CreateProduct();
        $envelope = Envelope::wrap($command, [new HandledStamp(true, 'handlerName')]);

        $commandBus = $this->createMock(MessageBusInterface::class);
        $commandBus->expects($this->once())
            ->method('dispatch')
            ->with($command)
            ->willReturn($envelope);

        $sfCommandBus = new SymfonyCommandBus($commandBus);

        $this->assertTrue($sfCommandBus->execute($command));
    }

    public function testAsyncDispatching(): void
    {
        $command = new CreateProduct();
        $envelope = Envelope::wrap($command, [new SentStamp('async')]);

        $commandBus = $this->createMock(MessageBusInterface::class);
        $commandBus->expects($this->once())
            ->method('dispatch')
            ->with($command)
            ->willReturn($envelope);

        $sfCommandBus = new SymfonyCommandBus($commandBus);

        $this->assertNull($sfCommandBus->execute($command));
    }
}
