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

namespace OpenSolid\Cqs\Command;

use OpenSolid\Bus\Error\NoHandlerForMessage;
use OpenSolid\Bus\MessageBus;
use OpenSolid\Cqs\Command\Error\NoHandlerForCommand;

readonly class NativeCommandBus implements CommandBus
{
    public function __construct(
        private MessageBus $messageBus,
    ) {
    }

    public function execute(Command $command): mixed
    {
        try {
            return $this->messageBus->dispatch($command);
        } catch (NoHandlerForMessage $e) {
            throw NoHandlerForCommand::from($command, $e);
        }
    }
}
