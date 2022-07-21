<?php

declare(strict_types=1);

namespace Fonil\Coloreeze;

use Fonil\Coloreeze\Exceptions\InvalidInput;

abstract class Color
{
    protected const MAP_REGEXP = [
        ColorCIELab::class  => '/^cielab\((\d*\.?\d+),([+|-]?\d*\.?\d+),([+|-]?\d*\.?\d+)\)$/i',
        ColorCMYK::class    => '/^cmyk\((\d*\.?\d+),(\d*\.?\d+),(\d*\.?\d+),(\d*\.?\d+)\)$/i',
        ColorHex::class     => '/^\#?([0-9A-F]{6}([0-9A-F]{2})?)$/i',
        ColorHSB::class     => '/^hs[b|v]\((\d*\.?\d+),([+|-]?\d*\.?\d+)\%?,([+|-]?\d*\.?\d+)\%?\)$/i',
        ColorHSL::class     => '/^hsl\((\d*\.?\d+),([+|-]?\d*\.?\d+)\%?,([+|-]?\d*\.?\d+)\%?\)$/i',
        ColorInt::class     => '/^int\((\d+)\)$/i',
        ColorRGBA::class    => '/^rgba\((\d+),(\d+),(\d+),?(\d*\.?\d+)?\)$/i',
        ColorXYZ::class     => '/^xyz\((\d*\.?\d+),([+|-]?\d*\.?\d+),([+|-]?\d*\.?\d+)\)$/i',
    ];

    protected const PRECISSION = 4;

    abstract public function __toString(): string;

    protected static function validateIsInRange(int|float $input, int|float $min, int|float $max, string $context): void
    {
        if (! self::isInRange($input, $min, $max)) {
            throw InvalidInput::notInRange($input, $min, $max, $context);
        }
    }

    protected static function validateFormat(string $input, string $className): void
    {
        if (preg_match(self::MAP_REGEXP[$className], $input) !== 1) {
            throw InvalidInput::wrongFormat($input, $className);
        }
    }

    private static function isInRange(mixed $value, mixed $min, mixed $max): bool
    {
        return ($min <= $value) && ($value <= $max);
    }
}
