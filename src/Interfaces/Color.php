<?php

declare(strict_types=1);

namespace Fonil\Coloreeze\Interfaces;

use Fonil\Coloreeze\ColorCIELab;
use Fonil\Coloreeze\ColorCMYK;
use Fonil\Coloreeze\ColorHex;
use Fonil\Coloreeze\ColorHSB;
use Fonil\Coloreeze\ColorHSL;
use Fonil\Coloreeze\ColorInt;
use Fonil\Coloreeze\ColorRGBA;
use Fonil\Coloreeze\ColorXYZ;

interface Color
{
    public function __toString(): string;

    public static function fromString(string $input): Color;

    public function adjustBrightness(int $percentage = 10): Color;

    public function distanceCIE76(Color $color): float;

    public function getValue(): mixed;

    public function toCIELab(): ColorCIELab;

    public function toCMYK(): ColorCMYK;

    public function toComplementary(): Color;

    public function toGreyscale(): Color;

    public function toHex(): ColorHex;

    public function toHSB(): ColorHSB;

    public function toHSL(): ColorHSL;

    public function toInt(): ColorInt;

    public function toRGBA(): ColorRGBA;

    public function toXYZ(): ColorXYZ;
}
