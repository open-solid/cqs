<?php

namespace OpenSolid\Tests\Cqs\Query;

use OpenSolid\Cqs\Query\SymfonyQueryBus;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use OpenSolid\Tests\Cqs\Fixtures\GetProducts;

class SymfonyQueryBusTest extends TestCase
{
    public function testExecute(): void
    {
        $query = new GetProducts();
        $envelope = Envelope::wrap($query, [new HandledStamp(['Product 1'], 'handlerName')]);

        $queryBus = $this->createMock(MessageBusInterface::class);
        $queryBus->expects($this->once())
            ->method('dispatch')
            ->with($query)
            ->willReturn($envelope);

        $sfQueryBus = new SymfonyQueryBus($queryBus);

        $this->assertSame(['Product 1'], $sfQueryBus->ask($query));
    }
}
