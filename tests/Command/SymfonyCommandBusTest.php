<?php

namespace OpenSolid\Tests\Cqs\Command;

use OpenSolid\Cqs\Command\SymfonyCommandBus;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use OpenSolid\Tests\Cqs\Fixtures\CreateProduct;

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
}
