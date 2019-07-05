<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Types\DateTime;

use Assert\Assert;
use DateTimeZone;
use Somnambulist\Domain\Entities\AbstractValueObject;

/**
 * Class TimeZone
 *
 * @package    Somnambulist\Domain\Entities\Types\DateTime
 * @subpackage Somnambulist\Domain\Entities\Types\DateTime\TimeZone
 */
class TimeZone extends AbstractValueObject
{

    /**
     * @var string
     */
    private $value;

    /**
     * Constructor.
     *
     * @param string $tz
     */
    public function __construct(string $tz)
    {
        Assert::that($tz, null, 'value')
            ->notEmpty()
            ->satisfy(function ($value) {
                return false !== @timezone_open($value);
            })
        ;

        $this->value = $tz;
    }

    /**
     * Creates a TimeZone instance using either the system default or supplied timezone
     *
     * @param null|string $tz
     *
     * @return static
     */
    public static function create($tz = null): self
    {
        return new static($tz ?? date_default_timezone_get());
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return (string)$this->value;
    }

    /**
     * @return DateTimeZone
     */
    public function toNative(): DateTimeZone
    {
        return new DateTimeZone($this->value);
    }
}
