<?php

declare(strict_types=1);

namespace Coloreeze\Interfaces;

use Coloreeze\ColorCIELab;
use Coloreeze\ColorCMYK;
use Coloreeze\ColorHex;
use Coloreeze\ColorHSB;
use Coloreeze\ColorHSL;
use Coloreeze\ColorInt;
use Coloreeze\ColorRGBA;
use Coloreeze\ColorXYZ;

interface Color
{
    public function __toString(): string;

    public function adjustBrightness(int $percentage = 10): Color;

    public function distanceCIE76(Color $color): float;

    public static function fromString(string $input): Color;

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
