<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Doctrine\Enumerations\Constructors;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use InvalidArgumentException;
use Somnambulist\Components\Domain\Entities\AbstractMultiton;

/**
 * Class TypedMultitonConstructor
 *
 * @package    Somnambulist\Components\Domain\Doctrine\Enumerations\Constructors
 * @subpackage Somnambulist\Components\Domain\Doctrine\Enumerations\Constructors\TypedMultitonConstructor
 */
class TypedMultitonConstructor
{
    public function __construct(private string $class)
    {
    }

    /**
     * @param string|int       $value
     * @param AbstractPlatform $platform
     *
     * @return AbstractMultiton|null
     * @throws InvalidArgumentException
     */
    public function __invoke(mixed $value, AbstractPlatform $platform): ?AbstractMultiton
    {
        if (is_null($value)) {
            return null;
        }

        /** @var AbstractMultiton $class */
        if (null !== $member = $this->class::memberOrNullByKey($value)) {
            return $member;
        }

        throw new InvalidArgumentException(sprintf(
            '"%s" is not a valid key for "%s"; should be one of: "%s"',
            $value,
            $this->class,
            implode(', ', $this->class::keys())
        ));
    }
}
