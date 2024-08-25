<?php

declare(strict_types=1);

namespace Coloreeze;

use Coloreeze\Interfaces\Color as ColorInterface;

final class ColorHSB extends Color implements ColorInterface
{
    public const VALUE_MAX__BRIGHTNESS = 100;
    public const VALUE_MAX__HUE = 360;
    public const VALUE_MAX__SATURATION = 100;
    public const VALUE_MIN__BRIGHTNESS = 0;
    public const VALUE_MIN__HUE = 0;
    public const VALUE_MIN__SATURATION = 0;

    public function __construct(
        private readonly float $hue,
        private readonly float $saturation,
        private readonly float $brightness
    ) {
        self::validateIsInRange(
            $this->hue,
            self::VALUE_MIN__HUE,
            self::VALUE_MAX__HUE,
            'ColorHSB (hue)'
        );

        self::validateIsInRange(
            $this->saturation,
            self::VALUE_MIN__SATURATION,
            self::VALUE_MAX__SATURATION,
            'ColorHSB (saturation)'
        );

        self::validateIsInRange(
            $this->brightness,
            self::VALUE_MIN__BRIGHTNESS,
            self::VALUE_MAX__BRIGHTNESS,
            'ColorHSB (brightness)'
        );
    }

    public function __toString(): string
    {
        $h = round($this->hue);
        $s = round($this->saturation);
        $b = round($this->brightness);

        return "hsb({$h},{$s}%,{$b}%)";
    }

    public function adjustBrightness(int $steps = 1): ColorHSB
    {
        return $this->toRGBA()->adjustBrightness($steps)->toHSB();
    }

    public function distanceCIE76(ColorInterface $color): float
    {
        return $this->toCIELab()->distanceCIE76($color->toCIELab());
    }

    public static function fromString(string $value): ColorHSB
    {
        self::validateFormat($value, self::class);

        preg_match(self::MAP_REGEXP[self::class], $value, $matches);

        return new static((float) $matches[1], (float) $matches[2], (float) $matches[3]);
    }

    public function getValue(): mixed
    {
        return [$this->hue, $this->saturation, $this->brightness];
    }

    public function toCIELab(): ColorCIELab
    {
        return $this->toXYZ()->toCIELab();
    }

    public function toCMYK(): ColorCMYK
    {
        return $this->toRGBA()->toCMYK();
    }

    public function toComplementary(): ColorHSB
    {
        return $this->toRGBA()->toComplementary()->toHSB();
    }

    public function toGreyscale(): ColorHSB
    {
        return $this->toRGBA()->toGreyscale()->toHSB();
    }

    public function toHex(): ColorHex
    {
        return $this->toRGBA()->toHex();
    }

    public function toHSB(): ColorHSB
    {
        return $this;
    }

    public function toHSL(): ColorHSL
    {
        return $this->toRGBA()->toHSL();
    }

    public function toInt(): ColorInt
    {
        return $this->toRGBA()->toInt();
    }

    public function toRGBA(): ColorRGBA
    {
        $hue = $this->hue;
        $saturation = $this->saturation;
        $brightness = $this->brightness;

        $hue /= 360;
        $saturation /= 100;
        $brightness /= 100;

        if (! $saturation) {
            $r = $g = $b = $brightness;
        } else {
            $hue *= 6;

            $i = floor($hue);
            $j = $brightness * (1 - $saturation);
            $k = $brightness * (1 - $saturation * ($hue - $i));
            $l = $brightness * (1 - $saturation * (1 - ($hue - $i)));

            switch ($i) {
                case 0:
                    $r = $brightness;
                    $g = $l;
                    $b = $j;
                    break;
                case 1:
                    $r = $k;
                    $g = $brightness;
                    $b = $j;
                    break;
                case 2:
                    $r = $j;
                    $g = $brightness;
                    $b = $l;
                    break;
                case 3:
                    $r = $j;
                    $g = $k;
                    $b = $brightness;
                    break;
                case 4:
                    $r = $l;
                    $g = $j;
                    $b = $brightness;
                    break;
                default:
                    $r = $brightness;
                    $g = $j;
                    $b = $k;
                    break;
            }
        }

        return new ColorRGBA(
            (int) round($r * 255, 0),
            (int) round($g * 255, 0),
            (int) round($b * 255, 0)
        );
    }

    public function toXYZ(): ColorXYZ
    {
        return $this->toRGBA()->toXYZ();
    }
}
