<?php

declare(strict_types=1);

namespace Fonil\Coloreeze;

use Fonil\Coloreeze\Interfaces\Color as ColorInterface;

final class ColorHSL extends Color implements ColorInterface
{
    public const VALUE_MAX__HUE = 360;
    public const VALUE_MAX__LIGHTNESS = 100;
    public const VALUE_MAX__SATURATION = 100;
    public const VALUE_MIN__HUE = 0;
    public const VALUE_MIN__LIGHTNESS = 0;
    public const VALUE_MIN__SATURATION = 0;

    public function __construct(
        private readonly float $hue,
        private readonly float $saturation,
        private readonly float $lightness
    ) {
        self::validateIsInRange(
            $this->hue,
            self::VALUE_MIN__HUE,
            self::VALUE_MAX__HUE,
            'ColorHSL (hue)'
        );

        self::validateIsInRange(
            $this->saturation,
            self::VALUE_MIN__SATURATION,
            self::VALUE_MAX__SATURATION,
            'ColorHSL (saturation)'
        );

        self::validateIsInRange(
            $this->lightness,
            self::VALUE_MIN__LIGHTNESS,
            self::VALUE_MAX__LIGHTNESS,
            'ColorHSL (lightness)'
        );
    }

    public function __toString(): string
    {
        $h = round($this->hue);
        $s = round($this->saturation);
        $l = round($this->lightness);

        return "hsl({$h},{$s}%,{$l}%)";
    }

    public function adjustBrightness(int $steps = 1): ColorHSL
    {
        return $this->toRGBA()->adjustBrightness($steps)->toHSL();
    }

    public function distanceCIE76(ColorInterface $color): float
    {
        return $this->toCIELab()->distanceCIE76($color->toCIELab());
    }

    public static function fromString(string $value): ColorHSL
    {
        self::validateFormat($value, self::class);

        preg_match(self::MAP_REGEXP[self::class], $value, $matches);

        return new static((float) $matches[1], (float) $matches[2], (float) $matches[3]);
    }

    public function getValue(): mixed
    {
        return [$this->hue, $this->saturation, $this->lightness];
    }

    public function toCIELab(): ColorCIELab
    {
        return $this->toXYZ()->toCIELab();
    }

    public function toCMYK(): ColorCMYK
    {
        return $this->toHex()->toCMYK();
    }

    public function toComplementary(): ColorHSL
    {
        return $this->toRGBA()->toComplementary()->toHSL();
    }

    public function toGreyscale(): ColorHSL
    {
        return $this->toRGBA()->toGreyscale()->toHSL();
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
        return $this;
    }

    public function toInt(): ColorInt
    {
        return $this->toHex()->toInt();
    }

    public function toRGBA(): ColorRGBA
    {
        $h = $this->hue;
        $s = $this->saturation;
        $l = $this->lightness;

        $h = intval((360 + (intval($h) % 360)) % 360);

        $c = (1 - abs(2 * ($l / self::VALUE_MAX__LIGHTNESS) - 1)) * $s / self::VALUE_MAX__SATURATION;
        $x = $c * (1 - abs(fmod($h / 60, 2) - 1));
        $m = ($l / self::VALUE_MAX__LIGHTNESS) - ($c / 2);

        if ($h <= 60) {
            return new ColorRGBA(
                (int) round(($c + $m) * ColorRGBA::VALUE_MAX__RED, 0),
                (int) round(($x + $m) * ColorRGBA::VALUE_MAX__GREEN, 0),
                (int) round($m * ColorRGBA::VALUE_MAX__BLUE, 0)
            );
        }

        if ($h <= 120) {
            return new ColorRGBA(
                (int) round(($x + $m) * ColorRGBA::VALUE_MAX__RED, 0),
                (int) round(($c + $m) * ColorRGBA::VALUE_MAX__GREEN, 0),
                (int) round($m * ColorRGBA::VALUE_MAX__BLUE, 0)
            );
        }

        if ($h <= 180) {
            return new ColorRGBA(
                (int) round($m * ColorRGBA::VALUE_MAX__RED, 0),
                (int) round(($c + $m) * ColorRGBA::VALUE_MAX__GREEN, 0),
                (int) round(($x + $m) * ColorRGBA::VALUE_MAX__BLUE, 0)
            );
        }

        if ($h <= 240) {
            return new ColorRGBA(
                (int) round($m * ColorRGBA::VALUE_MAX__RED, 0),
                (int) round(($x + $m) * ColorRGBA::VALUE_MAX__GREEN, 0),
                (int) round(($c + $m) * ColorRGBA::VALUE_MAX__BLUE, 0)
            );
        }

        if ($h <= 300) {
            return new ColorRGBA(
                (int) round(($x + $m) * ColorRGBA::VALUE_MAX__RED, 0),
                (int) round($m * ColorRGBA::VALUE_MAX__GREEN, 0),
                (int) round(($c + $m) * ColorRGBA::VALUE_MAX__BLUE, 0)
            );
        }

        return new ColorRGBA(
            (int) round(($c + $m) * ColorRGBA::VALUE_MAX__RED, 0),
            (int) round($m * ColorRGBA::VALUE_MAX__GREEN, 0),
            (int) round(($x + $m) * ColorRGBA::VALUE_MAX__BLUE, 0)
        );
    }

    public function toXYZ(): ColorXYZ
    {
        return $this->toRGBA()->toXYZ();
    }
}
