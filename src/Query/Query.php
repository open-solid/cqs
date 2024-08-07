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

namespace OpenSolid\Cqs\Query;

use OpenSolid\Bus\Envelope\Message;

/**
 * @template T
 * @template-extends Message<T>
 */
readonly class Query extends Message
{
}
