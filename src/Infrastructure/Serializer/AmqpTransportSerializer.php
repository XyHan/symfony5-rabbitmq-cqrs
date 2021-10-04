<?php

namespace App\Infrastructure\Serializer;

use App\Infrastructure\Bus\Model\AmqpEnvelope;
use App\Infrastructure\Serializer\Denormalizer\Command\MyCommandDenormalizer;
use App\Infrastructure\Serializer\Denormalizer\Model\AmqpEnvelopeDenormalizer;
use App\Infrastructure\ValueObject\CommandIndex;
use JetBrains\PhpStorm\ArrayShape;
use ReflectionClass;
use ReflectionException;
use Throwable;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\MessageDecodingFailedException;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface as MessengerSerializerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DataUriNormalizer;
use Symfony\Component\Serializer\Normalizer\DateIntervalNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeZoneNormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface as SymfonySerializerInterface;

/**
 * Class AmqpTransportSerializer
 */
final class AmqpTransportSerializer implements MessengerSerializerInterface
{
    /**
     * @var SymfonySerializerInterface
     */
    private SymfonySerializerInterface $serializer;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * AmqpTransportSerializer constructor.
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->setSerializer(
            [
                new ObjectNormalizer(),
                new GetSetMethodNormalizer(),
                new ArrayDenormalizer(),
                new DateTimeNormalizer(),
                new DateTimeZoneNormalizer(),
                new DataUriNormalizer(),
                new DateIntervalNormalizer(),
                new AmqpEnvelopeDenormalizer(),
                new MyCommandDenormalizer(),
            ],
            [
                new JsonEncoder(),
            ]
        );
        $this->logger = $logger;
    }

    /**
     * @param array $encodedEnvelope
     * @return Envelope
     * @throws Throwable
     */
    public function decode(array $encodedEnvelope): Envelope
    {
        try {
            /** @var AmqpEnvelope $amqpEnvelope */
            $amqpEnvelope = $this->getSerializer()->denormalize($encodedEnvelope, AmqpEnvelope::class, 'array');
            $headers = $amqpEnvelope->getHeaders();
            $body = $amqpEnvelope->getBody();

            if ($headers && array_key_exists('class', $headers)) {
                $command = CommandIndex::$commandIndex[$headers['class']];
                $body = $this->getSerializer()->deserialize($amqpEnvelope->getBody(), $command, 'json');
            }
        } catch (Throwable $exception) {
            $message = sprintf('AmqpTransportSerializer - decode - %s', $exception->getMessage());
            $this->logger->error($message);
            throw new MessageDecodingFailedException($message);
        }

        if (!$headers || !array_key_exists('class', $headers)) {
            throw new MessageDecodingFailedException('The message class is missing or is not supported.');
        }

        if (is_string($body)) {
            throw new MessageDecodingFailedException('The body is not a valid object.');
        }

        return new Envelope($body);
    }

    /**
     * @param Envelope $envelope
     * @return array
     * @throws ReflectionException
     */
    #[ArrayShape(['body' => "string", 'headers' => "array"])] public function encode(Envelope $envelope): array
    {
        $message = $envelope->getMessage();
        $class = new ReflectionClass($message->getName());
        return [
            'body' => $this->serializer->serialize($message, 'json'),
            'headers' => ['class' => $class->getShortName()],
        ];
    }

    /**
     * @param array $denormalizers
     * @param array $encoders
     * @return void
     */
    public function setSerializer(array $denormalizers, array $encoders): void
    {
        $this->serializer = new Serializer($denormalizers, $encoders);
    }

    /**
     * @return SymfonySerializerInterface
     */
    public function getSerializer(): SymfonySerializerInterface
    {
        return $this->serializer;
    }
}
