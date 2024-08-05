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

namespace OpenSolid\Tests\Cqs\Command;

use OpenSolid\Bus\Handler\MessageHandlersCountPolicy;
use OpenSolid\Bus\Handler\MessageHandlersLocator;
use OpenSolid\Bus\Middleware\HandlingMiddleware;
use OpenSolid\Bus\NativeMessageBus;
use OpenSolid\Cqs\Command\Error\NoHandlerForCommand;
use OpenSolid\Cqs\Command\NativeCommandBus;
use OpenSolid\Tests\Cqs\Fixtures\CreateProduct;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

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
        $handlerMiddleware = new HandlingMiddleware(new MessageHandlersLocator([
            CreateProduct::class => [$handler],
        ]), MessageHandlersCountPolicy::SINGLE_HANDLER);
        $commandBus = new NativeCommandBus(new NativeMessageBus([$handlerMiddleware]));

        $this->assertNull($commandBus->execute($command));
    }

    public function testNoHandlerForCommand(): void
    {
        $this->expectException(NoHandlerForCommand::class);
        $this->expectExceptionMessage('No handler for command "OpenSolid\Tests\Cqs\Fixtures\CreateProduct".');

        $handlerLocator = $this->createMock(ContainerInterface::class);
        $commandBus = new NativeCommandBus(new NativeMessageBus([new HandlingMiddleware($handlerLocator)]));

        $commandBus->execute(new CreateProduct());
    }
}
