<?php

namespace OpenSolid\Tests\Cqs\Command\Bridge;

use OpenSolid\Cqs\Command\Bridge\SymfonyCommandBus;
use OpenSolid\Tests\Cqs\Fixtures\CreateProduct;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

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
