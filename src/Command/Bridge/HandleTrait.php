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

use Symfony\Component\Messenger\Exception\LogicException;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Messenger\Stamp\SentStamp;

trait HandleTrait
{
    private MessageBusInterface $messageBus;
    private bool $allowAsyncHandling = false;

    private function handle(object $message): mixed
    {
        /** @psalm-suppress RedundantPropertyInitializationCheck */
        if (!isset($this->messageBus)) {
            throw new LogicException(sprintf('You must provide a "%s" instance in the "%s::$messageBus" property, but that property has not been initialized yet.', MessageBusInterface::class, static::class));
        }

        $envelope = $this->messageBus->dispatch($message);
        /** @var HandledStamp[] $handledStamps */
        $handledStamps = $envelope->all(HandledStamp::class);

        if (!$handledStamps) {
            if ($this->allowAsyncHandling && $envelope->all(SentStamp::class)) {
                // it went through an asynchronous transport
                return null;
            }

            throw new NoHandlerForMessageException(sprintf('Message of type "%s" was handled zero times. Exactly one handler is expected when using "%s::%s()".', get_debug_type($envelope->getMessage()), static::class, __FUNCTION__));
        }

        if (\count($handledStamps) > 1) {
            $handlers = implode(', ', array_map(fn (HandledStamp $stamp): string => sprintf('"%s"', $stamp->getHandlerName()), $handledStamps));

            throw new LogicException(sprintf('Message of type "%s" was handled multiple times. Only one handler is expected when using "%s::%s()", got %d: %s.', get_debug_type($envelope->getMessage()), static::class, __FUNCTION__, \count($handledStamps), $handlers));
        }

        return $handledStamps[0]->getResult();
    }
}
