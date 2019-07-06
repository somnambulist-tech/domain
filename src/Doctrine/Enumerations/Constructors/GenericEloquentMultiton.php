<?php declare(strict_types=1);

namespace Somnambulist\Domain\Doctrine\Enumerations\Constructors;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use InvalidArgumentException;
use Somnambulist\Domain\Entities\AbstractMultiton;

/**
 * Class GenericEloquentMultiton
 *
 * @package    Somnambulist\Domain\Doctrine\Enumerations\Constructors
 * @subpackage Somnambulist\Domain\Doctrine\Enumerations\Constructors\GenericEloquentMultiton
 */
class GenericEloquentMultiton
{

    /**
     * @param string           $value
     * @param string           $class
     * @param AbstractPlatform $platform
     *
     * @return AbstractMultiton
     * @throws InvalidArgumentException
     */
    public function __invoke(string $value, string $class, AbstractPlatform $platform)
    {
        if (is_null($value)) {
            return null;
        }

        /** @var AbstractMultiton $class */
        if (null !== $member = $class::memberOrNullByKey($value)) {
            return $member;
        }

        throw new InvalidArgumentException(sprintf(
            '"%s" is not a valid key for "%s"; should be one of: "%s"',
            $value,
            $class,
            implode(', ', $class::keys())
        ));
    }
}
