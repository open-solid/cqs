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

namespace OpenSolid\Cqs\Query\Error;

use OpenSolid\Cqs\Query\Query;

final class NoHandlerForQuery extends \LogicException
{
    public static function from(Query $query, ?\Throwable $previous = null, int $code = 0): self
    {
        return new self(sprintf('No handler for query of type "%s".', get_class($query)), $code, $previous);
    }
}
