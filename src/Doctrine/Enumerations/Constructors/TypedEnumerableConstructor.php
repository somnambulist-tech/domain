<?php declare(strict_types=1);

namespace Somnambulist\Domain\Doctrine\Enumerations\Constructors;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Eloquent\Enumeration\AbstractEnumeration;
use InvalidArgumentException;
use function in_array;

/**
 * Class TypedEnumerableConstructor
 *
 * @package    Somnambulist\Domain\Doctrine\Enumerations\Constructors
 * @subpackage Somnambulist\Domain\Doctrine\Enumerations\Constructors\TypedEnumerableConstructor
 */
class TypedEnumerableConstructor
{

    private string $class;
    private string $preCastAs;

    public function __construct(string $class, string $preCastAs = 'string')
    {
        if (!in_array($preCastAs, ['string', 'int'])) {
            throw new InvalidArgumentException(sprintf('preCastAs must be one of string or int, "%s" is not supported', $preCastAs));
        }

        $this->class     = $class;
        $this->preCastAs = $preCastAs;
    }

    /**
     * @param string           $value
     * @param AbstractPlatform $platform
     *
     * @return AbstractEnumeration
     * @throws InvalidArgumentException
     */
    public function __invoke(string $value, AbstractPlatform $platform)
    {
        if (is_null($value)) {
            return null;
        }
        if ('int' === $this->preCastAs) {
            $value = (int)$value;
        }

        $class = $this->class;

        if (null !== $member = $class::memberOrNullByValue($value)) {
            return $member;
        }

        throw new InvalidArgumentException(sprintf(
            '"%s" is not a valid value for "%s"; should be one of: "%s"',
            $value,
            $this->class,
            implode(', ', $this->class::members())
        ));
    }
}
