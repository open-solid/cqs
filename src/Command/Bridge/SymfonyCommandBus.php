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

namespace OpenSolid\Cqs\Command\Bridge;

use OpenSolid\Cqs\Command\Command;
use OpenSolid\Cqs\Command\CommandBus;
use OpenSolid\Cqs\Command\Error\NoHandlerForCommand;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\MessageBusInterface;

final class SymfonyCommandBus implements CommandBus
{
    use HandleTrait;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->messageBus = $commandBus;
        $this->allowAsyncHandling = true;
    }

    public function execute(Command $command): mixed
    {
        try {
            return $this->handle($command);
        } catch (NoHandlerForMessageException $e) {
            throw NoHandlerForCommand::create($command, $e);
        } catch (HandlerFailedException $e) {
            throw $e->getPrevious() ?? $e;
        }
    }
}
