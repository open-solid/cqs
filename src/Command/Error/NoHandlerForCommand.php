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

namespace OpenSolid\Cqs\Command\Error;

use OpenSolid\Cqs\Command\Command;

final class NoHandlerForCommand extends \LogicException
{
    public static function create(Command $command, ?\Throwable $previous = null, int $code = 0): self
    {
        return new self(sprintf('No handler for command "%s".', get_class($command)), $code, $previous);
    }
}
