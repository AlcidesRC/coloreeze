<?php

declare(strict_types=1);

namespace Coloreeze;

use Coloreeze\Interfaces\Color as ColorInterface;

final class ColorXYZ extends Color implements ColorInterface
{
    public const VALUE_MAX__X = 95.047;
    public const VALUE_MAX__Y = 100;
    public const VALUE_MAX__Z = 108.883;
    public const VALUE_MIN__X = 0;
    public const VALUE_MIN__Y = 0;
    public const VALUE_MIN__Z = 0;

    public function __construct(
        private readonly float $x,
        private readonly float $y,
        private readonly float $z
    ) {
        self::validateIsInRange(
            $this->x,
            self::VALUE_MIN__X,
            self::VALUE_MAX__X,
            'ColorXYZ (x)'
        );

        self::validateIsInRange(
            $this->y,
            self::VALUE_MIN__Y,
            self::VALUE_MAX__Y,
            'ColorXYZ (y)'
        );

        self::validateIsInRange(
            $this->z,
            self::VALUE_MIN__Z,
            self::VALUE_MAX__Z,
            'ColorXYZ (z)'
        );
    }

    public function __toString(): string
    {
        $x = number_format($this->x, self::PRECISSION);
        $y = number_format($this->y, self::PRECISSION);
        $z = number_format($this->z, self::PRECISSION);

        return "xyz({$x},{$y},{$z})";
    }

    public function adjustBrightness(int $steps = 1): ColorXYZ
    {
        return $this->toRGBA()->adjustBrightness($steps)->toXYZ();
    }

    public function distanceCIE76(ColorInterface $color): float
    {
        return $this->toCIELab()->distanceCIE76($color->toCIELab());
    }

    public static function fromString(string $value): ColorXYZ
    {
        self::validateFormat($value, self::class);

        preg_match(self::MAP_REGEXP[self::class], $value, $matches);

        return new static((float) $matches[1], (float) $matches[2], (float) $matches[3]);
    }

    public function getValue(): mixed
    {
        return [$this->x, $this->y, $this->z];
    }

    public function toCIELab(): ColorCIELab
    {
        $data = [
            'x' => $this->x / 95.047,
            'y' => $this->y / 100.000,
            'z' => $this->z / 108.883,
        ];

        $data = array_map(static function ($item) {
            if ($item > 0.008856) {
                return pow($item, 1 / 3);
            }
            return (7.787 * $item) + (16 / 116);
        }, $data);

        $l = round((116 * $data['y']) - 16, self::PRECISSION);
        $a = round(500 * ($data['x'] - $data['y']), self::PRECISSION);
        $b = round(200 * ($data['y'] - $data['z']), self::PRECISSION);

        return new ColorCIELab($l, $a, $b);
    }

    public function toCMYK(): ColorCMYK
    {
        return $this->toRGBA()->toHex()->toCMYK();
    }

    public function toComplementary(): ColorXYZ
    {
        return $this->toRGBA()->toComplementary()->toXYZ();
    }

    public function toGreyscale(): ColorXYZ
    {
        return $this->toRGBA()->toGreyscale()->toXYZ();
    }

    public function toHex(): ColorHex
    {
        return $this->toRGBA()->toHex();
    }

    public function toHSB(): ColorHSB
    {
        return $this->toRGBA()->toHSB();
    }

    public function toHSL(): ColorHSL
    {
        return $this->toRGBA()->toHSL();
    }

    public function toInt(): ColorInt
    {
        return $this->toRGBA()->toHex()->toInt();
    }

    public function toRGBA(): ColorRGBA
    {
        $x = $this->x / 100;
        $y = $this->y / 100;
        $z = $this->z / 100;

        $r = $x * 3.2406 + $y * -1.5372 + $z * -0.4986;
        $g = $x * -0.9689 + $y * 1.8758 + $z * 0.0415;
        $b = $x * 0.0557 + $y * -0.2040 + $z * 1.0570;

        if ($r > 0.0031308) {
            $r = 1.055 * pow($r, 1 / 2.4) - 0.055;
        } else {
            $r = 12.92 * $r;
        }

        if ($g > 0.0031308) {
            $g = 1.055 * pow($g, 1 / 2.4) - 0.055;
        } else {
            $g = 12.92 * $g;
        }

        if ($b > 0.0031308) {
            $b = 1.055 * pow($b, 1 / 2.4) - 0.055;
        } else {
            $b = 12.92 * $b;
        }

        $r = intval(max(0, min(255, $r * 255)));
        $g = intval(max(0, min(255, $g * 255)));
        $b = intval(max(0, min(255, $b * 255)));

        return new ColorRGBA($r, $g, $b);
    }

    public function toXYZ(): ColorXYZ
    {
        return $this;
    }
}
