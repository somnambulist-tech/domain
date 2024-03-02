<?php declare(strict_types=1);

namespace Somnambulist\Components\Events\Adapters;

use IlluminateAgnostic\Str\Support\Str;
use Somnambulist\Components\Events\AbstractEvent;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use function class_exists;
use function is_a;

class DomainEventNormalizer implements NormalizerInterface, DenormalizerInterface
{
    public function __construct(private readonly array $supportedEventPrefixes = [])
    {
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            AbstractEvent::class,
        ];
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
    {
        return
            (class_exists($type) && is_a($type, AbstractEvent::class, true))
            ||
            (count($this->supportedEventPrefixes) > 0 && Str::startsWith($type, $this->supportedEventPrefixes))
        ;
    }

    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return $data instanceof AbstractEvent;
    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): mixed
    {
        return AbstractEvent::fromArray(
            $type,
            $data
        );
    }

    public function normalize(mixed $object, string $format = null, array $context = []): array
    {
        return $object->toArray();
    }
}
