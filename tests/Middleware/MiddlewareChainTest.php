<?php

namespace Yceruto\Cqs\Tests\Middleware;

use PHPUnit\Framework\TestCase;
use stdClass;
use Yceruto\Cqs\Middleware\Envelop;
use Yceruto\Cqs\Middleware\Middleware;
use Yceruto\Cqs\Middleware\MiddlewareChain;

class MiddlewareChainTest extends TestCase
{
    public function testHandle(): void
    {
        $middleware1 = new class() implements Middleware {
            public function handle(Envelop $envelop, callable $next): void
            {
                $envelop->result = '1';
                $next($envelop);
            }
        };
        $middleware2 = new class() implements Middleware {
            public function handle(Envelop $envelop, callable $next): void
            {
                $envelop->result .= '2';
                $next($envelop);
            }
        };
        $middleware3 = new class() implements Middleware {
            public function handle(Envelop $envelop, callable $next): void
            {
                $envelop->result .= '3';
                $next($envelop);
            }
        };
        $stack = new MiddlewareChain([$middleware1, $middleware2, $middleware3]);
        $envelop = Envelop::wrap(new stdClass());
        $stack->handle($envelop);

        $this->assertSame('123', $envelop->result);
    }
}
