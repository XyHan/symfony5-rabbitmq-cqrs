<?php

namespace App\Tests\Infrastructure\Serializer;

use App\Application\Command\MyCommand\MyCommand;
use App\Infrastructure\Bus\Model\AmqpEnvelope;
use App\Infrastructure\Serializer\AmqpTransportSerializer;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use Symfony\Component\Messenger\Envelope;
use Throwable;

/**
 * Class AmqpTransportSerializerTest
 */
final class AmqpTransportSerializerTest extends TestCase
{
    /**
     * @throws ReflectionException
     */
    public function testEncodeSuccess(): void
    {
        $logger = $this->createMock(Logger::class);
        $serializer = new AmqpTransportSerializer($logger);
        $encodedEnvelope = $serializer->encode(new Envelope(new AmqpEnvelope(), []));
        $this->assertEquals('{"name":"App\\\Infrastructure\\\Bus\\\Model\\\AmqpEnvelope"}', $encodedEnvelope['body']);
        $this->assertEquals(1, count($encodedEnvelope['headers']));
        $this->assertEquals('AmqpEnvelope', $encodedEnvelope['headers']['class']);
    }

    /**
     * @throws Throwable
     */
    public function testDecodeSuccess(): void
    {
        $encodedEnvelope = [
            'body' => '{"requestId":"5be3d8f8-3b27-4501-933e-ea0207269574","userUuid":"5be3d8f8-3b27-4501-933e-ea0207269574","uuid":"5be3d8f8-3b27-4501-933e-ea0207269574"}',
            'headers' => ['class' => 'MyCommand']
        ];
        $logger = $this->createMock(Logger::class);
        $serializer = new AmqpTransportSerializer($logger);
        $envelope = $serializer->decode($encodedEnvelope);
        $this->assertInstanceOf(MyCommand::class, $envelope->getMessage());
    }
}
