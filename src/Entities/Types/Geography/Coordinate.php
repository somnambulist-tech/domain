<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Entities\Types\Geography;

use Assert\Assert;
use Somnambulist\Components\Domain\Entities\AbstractValueObject;

/**
 * Class Coordinate
 *
 * Represents a latitude and longitude within a geo-spatial system.
 *
 * @package    Somnambulist\Components\Domain\Entities\Types\Geography
 * @subpackage Somnambulist\Components\Domain\Entities\Types\Geography\Coordinate
 */
class Coordinate extends AbstractValueObject
{
    public function __construct(private float $latitude, private float $longitude, private Srid $srid)
    {
        Assert::lazy()->tryAll()
            ->that($latitude, 'latitude')->range(-90, 90)
            ->that($longitude, 'longitude')->range(-180, 180)
            ->verifyNow()
        ;
    }

    public function toString(): string
    {
        return sprintf('[%s, %s]', $this->longitude, $this->latitude);
    }

    public function toGeoJson(): string
    {
        return json_encode([
            'type'        => 'Point',
            'coordinates' => [
                $this->longitude, $this->latitude,
            ],
            'crs'         => [
                'type'       => 'name',
                'properties' => [
                    'name' => 'EPSG:' . $this->srid(),
                ],
            ],
        ]);
    }

    public function latitude(): float
    {
        return $this->latitude;
    }

    public function longitude(): float
    {
        return $this->longitude;
    }

    public function srid(): Srid
    {
        return $this->srid;
    }
}
