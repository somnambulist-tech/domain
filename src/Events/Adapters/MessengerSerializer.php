<?php declare(strict_types=1);

namespace Somnambulist\Components\Events\Adapters;

use Somnambulist\Components\Events\AbstractEvent;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\InvalidArgumentException;
use Symfony\Component\Messenger\Exception\LogicException;
use Symfony\Component\Messenger\Exception\MessageDecodingFailedException;
use Symfony\Component\Messenger\Stamp\NonSendableStampInterface;
use Symfony\Component\Messenger\Stamp\SerializerStamp;
use Symfony\Component\Messenger\Transport\Serialization\PhpSerializer;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer as SymfonySerializer;
use Symfony\Component\Serializer\SerializerInterface as SymfonySerializerInterface;
use function array_merge;
use function class_exists;
use function sprintf;
use function str_starts_with;
use function strlen;
use function substr;
use function trigger_deprecation;

class MessengerSerializer implements SerializerInterface
{
    private const STAMP_HEADER_PREFIX = 'X-Message-Stamp-';

    private SymfonySerializer $serializer;
    private string $format;
    private array $context;

    public function __construct(SymfonySerializerInterface $serializer = null, string $format = 'json', array $context = [])
    {
        $this->serializer = $serializer ?? self::create()->serializer;
        $this->format     = $format;
        $this->context    = $context;

        trigger_deprecation('somnambulist/domain', '4.5.0', '%s is deprecated; use %s instead', self::class, DomainEventNormalizer::class);
    }

    public static function create(): self
    {
        if (!class_exists(SymfonySerializer::class)) {
            throw new LogicException(
                sprintf(
                    'The "%s" class requires Symfony\'s Serializer component. Try running "composer require symfony/serializer" or use "%s" instead.',
                    __CLASS__,
                    PhpSerializer::class
                )
            );
        }

        $encoders    = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ArrayDenormalizer(), new ObjectNormalizer()];
        $serializer  = new SymfonySerializer($normalizers, $encoders);

        return new self($serializer);
    }

    public function decode(array $encodedEnvelope): Envelope
    {
        if (empty($encodedEnvelope['body']) || empty($encodedEnvelope['headers'])) {
            throw new MessageDecodingFailedException('Encoded envelope should have at least a "body" and some "headers".');
        }

        if (empty($encodedEnvelope['headers']['type'])) {
            throw new MessageDecodingFailedException('Encoded envelope does not have a "type" header.');
        }

        $stamps          = $this->decodeStamps($encodedEnvelope);
        $serializerStamp = $this->findFirstSerializerStamp($stamps);

        $context = $this->context;
        if (null !== $serializerStamp) {
            $context = $serializerStamp->getContext() + $context;
        }

        try {
            $message = AbstractEvent::fromArray(
                $encodedEnvelope['headers']['type'],
                $this->serializer->decode($encodedEnvelope['body'], $this->format, $context)
            );

        } catch (UnexpectedValueException $e) {
            throw new MessageDecodingFailedException(sprintf('Could not decode message: %s.', $e->getMessage()), $e->getCode(), $e);
        }

        return new Envelope($message, $stamps);
    }

    private function decodeStamps(array $encodedEnvelope): array
    {
        $stamps = [];

        foreach ($encodedEnvelope['headers'] as $name => $value) {
            if (!str_starts_with($name, self::STAMP_HEADER_PREFIX)) {
                continue;
            }

            try {
                $stamps[] = $this->serializer->deserialize($value, substr($name, strlen(self::STAMP_HEADER_PREFIX)) . '[]', $this->format, $this->context);
            } catch (UnexpectedValueException $e) {
                throw new MessageDecodingFailedException(sprintf('Could not decode stamp: %s.', $e->getMessage()), $e->getCode(), $e);
            }
        }

        if ($stamps) {
            $stamps = array_merge(...$stamps);
        }

        return $stamps;
    }

    public function encode(Envelope $envelope): array
    {
        if (!$envelope->getMessage() instanceof AbstractEvent) {
            throw new InvalidArgumentException(
                sprintf('"%s" will only operate on "%s" objects', __CLASS__, AbstractEvent::class)
            );
        }

        $context = $this->context;
        /** @var SerializerStamp|null $serializerStamp */
        if ($serializerStamp = $envelope->last(SerializerStamp::class)) {
            $context = $serializerStamp->getContext() + $context;
        }

        $envelope = $envelope->withoutStampsOfType(NonSendableStampInterface::class);

        $headers = ['type' => $envelope->getMessage()->type()] + $this->encodeStamps($envelope) + $this->getContentTypeHeader();

        return [
            'body'    => $this->serializer->encode($envelope->getMessage()->toArray(), $this->format, $context),
            'headers' => $headers,
        ];
    }

    private function encodeStamps(Envelope $envelope): array
    {
        if (!$allStamps = $envelope->all()) {
            return [];
        }

        $headers = [];
        foreach ($allStamps as $class => $stamps) {
            $headers[self::STAMP_HEADER_PREFIX . $class] = $this->serializer->serialize($stamps, $this->format, $this->context);
        }

        return $headers;
    }

    private function findFirstSerializerStamp(array $stamps): ?SerializerStamp
    {
        foreach ($stamps as $stamp) {
            if ($stamp instanceof SerializerStamp) {
                return $stamp;
            }
        }

        return null;
    }

    private function getContentTypeHeader(): array
    {
        $mimeType = $this->getMimeTypeForFormat();

        return null === $mimeType ? [] : ['Content-Type' => $mimeType];
    }

    private function getMimeTypeForFormat(): ?string
    {
        return match ($this->format) {
            'json' => 'application/json',
            'xml' => 'application/xml',
            'yml', 'yaml' => 'application/x-yaml',
            'csv' => 'text/csv',
            default => null,
        };
    }
}
