<?php

namespace Yceruto\Cqs\Tests\Command;

use PHPUnit\Framework\TestCase;
use Yceruto\Cqs\Command\InMemoryCommandBus;
use Yceruto\Cqs\Tests\Command\Fixtures\CreateProduct;

class InMemoryCommandBusTest extends TestCase
{
    public function testExecuteCommand(): void
    {
        $tester = $this;
        $command = new CreateProduct();
        $commandBus = new InMemoryCommandBus([
            CreateProduct::class => new class($tester) {
                public function __construct(private readonly TestCase $tester)
                {
                }

                public function __invoke(CreateProduct $command): void
                {
                    /** @psalm-suppress InternalMethod */
                    $this->tester->addToAssertionCount(1);
                }
            },
        ]);

        $commandBus->execute($command);
    }
}
