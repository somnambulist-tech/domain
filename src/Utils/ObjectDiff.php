<?php declare(strict_types=1);

namespace Somnambulist\Components\Utils;

use InvalidArgumentException;
use ReflectionObject;
use function is_iterable;
use function is_object;
use function is_scalar;
use function sprintf;

/**
 * Diff Objects
 *
 * Attempts to compare two objects of the same type, property by property, producing
 * an array of property names that contain differences in values. All properties will be
 * checked including parent properties, protected and private members. Static members
 * are ignored. Differences are presented as mine => , theirs => for each property.
 * Nesting order is preserved: see tests for examples.
 *
 * Collections (arrays) will be compared element by element. If the elements in the
 * collection have differences, then only the ones that differ will appear e.g.: two
 * objects will sub-objects one with 3 the other with 2, will only show differences where
 * the keys match between the collections.
 *
 * @experimental added in 4.2.0
 */
class ObjectDiff
{
    public function diff(object $a, object $b): array
    {
        if ($a::class !== $b::class) {
            throw new InvalidArgumentException(sprintf('Expected instance of "%s" to diff with, received "%s"', $a::class, $b::class));
        }
        if ($a === $b) {
            return [];
        }

        $diff   = [];
        $refObj = new ReflectionObject($a);

        do {
            foreach ($refObj->getProperties() as $prop) {
                if ($prop->isStatic()) {
                    // ignore static properties as these are usually instances or caches
                    continue;
                }

                $prop->setAccessible(true);
                $mine   = $prop->getValue($a);
                $theirs = $prop->getValue($b);

                $this->testScalarValue($diff, $prop->getName(), $mine, $theirs);
                $this->testIterableValue($diff, $prop->getName(), $mine, $theirs);
                $this->testObjectValue($diff, $prop->getName(), $mine, $theirs);
            }
        } while ($refObj = $refObj->getParentClass());

        return array_filter($diff);
    }

    private function diffIterable($mine, $theirs): array
    {
        $diff = [];

        foreach ($mine as $key => $value) {
            $this->testScalarValue($diff, (string)$key, $value, $theirs[$key] ?? null);
            $this->testIterableValue($diff, (string)$key, $value, $theirs[$key] ?? null);
            $this->testObjectValue($diff, (string)$key, $value, $theirs[$key] ?? null);
        }

        return $diff;
    }

    private function testScalarValue(array &$diff, string $prop, mixed $mine, mixed $theirs): void
    {
        if ((is_scalar($mine) || is_null($mine)) && $mine !== $theirs) {
            $diff[$prop] = [
                'mine'   => $mine,
                'theirs' => $theirs,
            ];
        }
    }

    private function testIterableValue(array &$diff, string $prop, mixed $mine, mixed $theirs): void
    {
        if (is_iterable($mine) && $mine != $theirs) {
            $diff[$prop] = $this->diffIterable($mine, $theirs);
        }
    }

    private function testObjectValue(array &$diff, string $prop, mixed $mine, mixed $theirs): void
    {
        if (is_object($mine) && is_object($theirs) && $mine !== $theirs) {
            $diff[$prop] = array_filter($this->diff($mine, $theirs));
        }
    }
}
