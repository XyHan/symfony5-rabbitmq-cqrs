<?php

namespace App\Tests\Application\Command\MyCommand;

use App\Application\Command\MyCommand\MyCommand;
use App\Application\Command\MyCommand\MyCommandHandler;
use App\Domain\Event\EventBus;
use App\Domain\Factory\MyModelFactory\MyModelFactoryInterface;
use App\Domain\Repository\MyModelCommandRepositoryInterface;
use App\Infrastructure\Bus\MessengerEventBus;
use Exception;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class MyCommandHandlerTest
 */
final class MyCommandHandlerTest extends TestCase
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var EventBus
     */
    private EventBus $eventBus;

    /**
     * @var MyModelFactoryInterface
     */
    private MyModelFactoryInterface $factory;

    /**
     * @var MyModelCommandRepositoryInterface
     */
    private MyModelCommandRepositoryInterface $commandRepository;

    protected function setUp(): void
    {
        $this->factory = $this->createMock(MyModelFactoryInterface::class);
        $this->commandRepository = $this->createMock(MyModelCommandRepositoryInterface::class);
        $this->logger = $this->createMock(Logger::class);
        $this->eventBus = $this->createMock(MessengerEventBus::class);
    }

    public function testHandleSuccess(): void
    {
        $command = new MyCommand(
            '5be3d8f8-3b27-4501-933e-ea0207269574',
            '30b372b5-091a-43fd-86ff-5dde9f9ff681',
            'd6780344-9eff-4ea8-b9fd-3b2fd11af9f7',
        );
        $handler = new MyCommandHandler($this->factory, $this->commandRepository, $this->logger, $this->eventBus);
        $isOk = true;
        try {
            $handler->__invoke($command);
        } catch (Exception $exception) {
            $isOk = false;
        }

        $this->assertTrue($isOk);
    }
}
