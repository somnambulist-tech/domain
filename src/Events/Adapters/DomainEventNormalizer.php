<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Events\Adapters;

use IlluminateAgnostic\Str\Support\Str;
use Somnambulist\Components\Domain\Events\AbstractEvent;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use function class_exists;
use function is_a;
use function str_contains;

/**
 * Class DomainEventNormalizer
 *
 * @package    Somnambulist\Components\Domain\Events\Adapters
 * @subpackage Somnambulist\Components\Domain\Events\Adapters\DomainEventNormalizer
 */
class DomainEventNormalizer implements ContextAwareNormalizerInterface, ContextAwareDenormalizerInterface, CacheableSupportsMethodInterface
{
    public function __construct(private array $supportedEventPrefixes = [])
    {
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
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
