<?php
declare(strict_types=1);

namespace App\Tests\Shared\Infrastructure\System\CQRS;

use App\Shared\Domain\System\CQRS\Command;
use App\Shared\Infrastructure\System\CQRS\MessengerCommandBus;
use App\Shared\Infrastructure\System\CQRS\SpyCommandBus;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerCommandBusTest extends TestCase
{
    private MessageBusInterface $symfonyMessageBus;
    private MessengerCommandBus $commandBus;

    /** @test */
    public function messageIsForwardedToMessageBusWhileDispatching(): void
    {
        $command = new class() implements Command {

        };
        $this->commandBus->dispatch($command);

        self::assertSame($command, $this->symfonyMessageBus->lastDispatchedCommand());
    }

    protected function setUp(): void
    {
        $this->symfonyMessageBus = new SpyCommandBus();
        $this->commandBus = new MessengerCommandBus($this->symfonyMessageBus);
    }
}