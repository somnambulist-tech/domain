<?php declare(strict_types=1);

namespace Somnambulist\Components\Queries\Behaviours;

use function array_map;
use function in_array;

trait CanConvertValueToBoolean
{
    private function convertStringToBoolean(string $value): bool
    {
        return $this->convertStringsToBoolean([$value])[0];
    }

    private function convertBooleanToString(bool $value): bool
    {
        return $this->convertBooleansToString([$value])[0];
    }

    private function convertStringsToBoolean(array $values): array
    {
        return array_map(function ($value) {
            if (in_array($value, ['true', '1', 1, 'yes', 'on'], true)) {
                return true;
            } elseif (in_array($value, ['false', '0', 0, 'no', 'off'], true)) {
                return false;
            }

            return $value;
        }, $values);
    }

    private function convertBooleansToString(array $values): array
    {
        return array_map(function ($value) {
            if (true === $value) {
                return 'true';
            } elseif (false === $value) {
                return 'false';
            }

            return $value;
        }, $values);
    }
}
