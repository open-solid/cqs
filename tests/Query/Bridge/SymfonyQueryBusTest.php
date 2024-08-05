<?php

declare(strict_types=1);

/*
 * This file is part of OpenSolid package.
 *
 * (c) Yonel Ceruto <open@yceruto.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OpenSolid\Tests\Cqs\Query\Bridge;

use OpenSolid\Cqs\Query\Bridge\SymfonyQueryBus;
use OpenSolid\Tests\Cqs\Fixtures\GetProducts;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

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
