<?php

declare(strict_types=1);

namespace Fonil\Coloreeze;

use Fonil\Coloreeze\Exceptions\InvalidInput;
use Fonil\Coloreeze\Interfaces\Color as ColorInterface;

final class ColorFactory
{
    private const AVAILABLE_CLASSES = [
        ColorCIELab::class,
        ColorCMYK::class,
        ColorHex::class,
        ColorHSB::class,
        ColorHSL::class,
        ColorInt::class,
        ColorRGBA::class,
        ColorXYZ::class,
    ];

    public static function fromString(string $input): ColorInterface
    {
        foreach (self::AVAILABLE_CLASSES as $class) {
            try {
                return $class::fromString($input);
            } catch (InvalidInput $e) {
                // Catch the exception but never throw it.
            }
        }

        throw InvalidInput::notMatchingAnyColor($input);
    }
}
