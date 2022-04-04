<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Events\Adapters;

use Somnambulist\Components\Domain\Events\AbstractEvent;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use function is_a;

/**
 * Class DomainEventNormalizer
 *
 * @package    Somnambulist\Components\Domain\Events\Adapters
 * @subpackage Somnambulist\Components\Domain\Events\Adapters\DomainEventNormalizer
 */
class DomainEventNormalizer implements ContextAwareNormalizerInterface, ContextAwareDenormalizerInterface, CacheableSupportsMethodInterface
{
    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
    {
        return is_a($type, AbstractEvent::class, true);
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
