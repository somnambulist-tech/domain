<?php declare(strict_types=1);

namespace Somnambulist\Domain\Entities\Types\Geography;

use Assert\Assert;
use Somnambulist\Domain\Entities\AbstractValueObject;

/**
 * Class Coordinate
 *
 * Represents a latitude and longitude within a geo-spatial system.
 *
 * @package    Somnambulist\Domain\Entities\Types\Geography
 * @subpackage Somnambulist\Domain\Entities\Types\Geography\Coordinate
 */
class Coordinate extends AbstractValueObject
{

    private float $latitude;
    private float $longitude;
    private Srid $srid;

    public function __construct(float $latitude, float $longitude, Srid $srid)
    {
        Assert::lazy()->tryAll()
            ->that($latitude, 'latitude')->range(-90, 90)
            ->that($longitude, 'longitude')->range(-180, 180)
            ->verifyNow()
        ;

        $this->latitude  = $latitude;
        $this->longitude = $longitude;
        $this->srid      = $srid;
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
