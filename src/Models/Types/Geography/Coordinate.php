<?php declare(strict_types=1);

namespace Somnambulist\Components\Models\Types\Geography;

use Assert\Assert;
use Somnambulist\Components\Models\AbstractValueObject;

/**
 * Represents a latitude and longitude within a geospatial system.
 */
final class Coordinate extends AbstractValueObject
{
    public function __construct(
        private readonly float $latitude,
        private readonly float $longitude,
        private readonly Srid $srid
    ) {
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
