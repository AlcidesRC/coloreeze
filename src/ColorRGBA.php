<?php

declare(strict_types=1);

namespace Fonil\Coloreeze;

use Fonil\Coloreeze\Interfaces\Color as ColorInterface;

final class ColorRGBA extends Color implements ColorInterface
{
    public const VALUE_MAX__ALPHA = 1;
    public const VALUE_MAX__BLUE = 255;
    public const VALUE_MAX__GREEN = 255;
    public const VALUE_MAX__RED = 255;
    public const VALUE_MIN__ALPHA = 0;
    public const VALUE_MIN__BLUE = 0;
    public const VALUE_MIN__GREEN = 0;
    public const VALUE_MIN__RED = 0;

    public function __construct(
        private readonly int $red,
        private readonly int $green,
        private readonly int $blue,
        private readonly float $alpha = self::VALUE_MAX__ALPHA
    ) {
        self::validateIsInRange(
            $this->red,
            self::VALUE_MIN__RED,
            self::VALUE_MAX__RED,
            'ColorRGBA (red)'
        );

        self::validateIsInRange(
            $this->green,
            self::VALUE_MIN__GREEN,
            self::VALUE_MAX__GREEN,
            'ColorRGBA (green)'
        );

        self::validateIsInRange(
            $this->blue,
            self::VALUE_MIN__BLUE,
            self::VALUE_MAX__BLUE,
            'ColorRGBA (blue)'
        );

        self::validateIsInRange(
            $this->alpha,
            self::VALUE_MIN__ALPHA,
            self::VALUE_MAX__ALPHA,
            'ColorRGBA (alpha)'
        );
    }

    public function __toString(): string
    {
        $r = round($this->red);
        $g = round($this->green);
        $b = round($this->blue);
        $a = round($this->alpha, self::PRECISSION);

        return "rgba({$r},{$g},{$b},{$a})";
    }

    public function adjustBrightness(int $steps = 1): ColorRGBA
    {
        $r = max(0, min(255, $this->red + $steps));
        $g = max(0, min(255, $this->green + $steps));
        $b = max(0, min(255, $this->blue + $steps));

        return new ColorRGBA($r, $g, $b);
    }

    public function distanceCIE76(ColorInterface $color): float
    {
        return $this->toCIELab()->distanceCIE76($color->toCIELab());
    }

    public static function fromString(string $value): ColorRGBA
    {
        self::validateFormat($value, self::class);

        preg_match(self::MAP_REGEXP[self::class], $value, $matches);

        return new static((int) $matches[1], (int) $matches[2], (int) $matches[3], (float) ($matches[4] ?? 1));
    }

    public function getValue(): mixed
    {
        return [$this->red, $this->green, $this->blue, $this->alpha];
    }

    public function toCIELab(): ColorCIELab
    {
        return $this->toXYZ()->toCIELab();
    }

    public function toCMYK(): ColorCMYK
    {
        return $this->toHex()->toCMYK();
    }

    public function toComplementary(): ColorRGBA
    {
        $r = 255 - $this->red;
        $g = 255 - $this->green;
        $b = 255 - $this->blue;
        $a = $this->alpha;

        return new ColorRGBA($r, $g, $b, $a);
    }

    public function toGreyscale(): ColorRGBA
    {
        $avg = (int) round(($this->red + $this->green + $this->blue) / 3, 0);

        return new ColorRGBA($avg, $avg, $avg, $this->alpha);
    }

    public function toHex(): ColorHex
    {
        $toHexadecimal = static function (int $channel): string {
            return str_pad(dechex($channel), 2, '0', STR_PAD_LEFT);
        };

        $r = $toHexadecimal($this->red);
        $g = $toHexadecimal($this->green);
        $b = $toHexadecimal($this->blue);
        $a = dechex((int) round($this->alpha * 255, 0));

        return new ColorHex("#{$r}{$g}{$b}{$a}");
    }

    public function toHSB(): ColorHSB
    {
        $r = $this->red / 255;
        $g = $this->green / 255;
        $b = $this->blue / 255;

        $min = min($r, $g, $b);
        $max = max($r, $g, $b);
        $delta = $max - $min;

        $_h = 0;

        $_b = $max;

        if (! $delta) {
            $_h = 0;
            $_s = 0;
        } else {
            $_s = $delta / $max;

            $deltaR = ((($max - $r) / 6) + ($delta / 2)) / $delta;
            $deltaG = ((($max - $g) / 6) + ($delta / 2)) / $delta;
            $deltaB = ((($max - $b) / 6) + ($delta / 2)) / $delta;

            if ($r === $max) {
                $_h = $deltaB - $deltaG;
            } else {
                if ($g === $max) {
                    $_h = (1 / 3) + $deltaR - $deltaB;
                } else {
                    if ($b === $max) {
                        $_h = (2 / 3) + $deltaG - $deltaR;
                    }
                }
            }

            if ($_h < 0) {
                $_h++;
            }

            /*
            if ($_h > 1) {
                $_h --;
            }
            */
        }

        $_h *= 360;
        $_s *= 100;
        $_b *= 100;

        return new ColorHSB(
            round($_h, self::PRECISSION),
            round($_s, self::PRECISSION),
            round($_b, self::PRECISSION)
        );
    }

    public function toHSL(): ColorHSL
    {
        $r = $this->red / self::VALUE_MAX__RED;
        $g = $this->green / self::VALUE_MAX__GREEN;
        $b = $this->blue / self::VALUE_MAX__BLUE;

        $max = max($r, $g, $b);
        $min = min($r, $g, $b);
        $delta = $max - $min;

        $hue = 0;
        if ($delta > 0) {
            if ($r === $max) {
                $hue = 60 * fmod(($g - $b) / $delta, 6);
                $hue = $hue < 0 ? $hue + 360 : $hue;
            }

            if ($g === $max) {
                $hue = 60 * ((($b - $r) / $delta) + 2);
            }

            if ($b === $max) {
                $hue = 60 * ((($r - $g) / $delta) + 4);
            }
        }

        $lightness = ($max + $min) / 2;

        $saturation = 0;

        if ($lightness > 0 && $lightness < 1) {
            $saturation = $delta / (1 - abs((2 * $lightness) - 1));
        }

        return new ColorHSL(
            round($hue),
            round(min($saturation, 1) * ColorHSL::VALUE_MAX__SATURATION),
            round(min($lightness, 1) * ColorHSL::VALUE_MAX__LIGHTNESS)
        );
    }

    public function toInt(): ColorInt
    {
        return $this->toHex()->toInt();
    }

    public function toRGBA(): ColorRGBA
    {
        return $this;
    }

    public function toXYZ(): ColorXYZ
    {
        $r = $this->red / self::VALUE_MAX__RED;
        $g = $this->green / self::VALUE_MAX__GREEN;
        $b = $this->blue / self::VALUE_MAX__BLUE;

        if ($r > 0.04045) {
            $r = pow(($r + 0.055) / 1.055, 2.4);
        } else {
            $r /= 12.92;
        }

        if ($g > 0.04045) {
            $g = pow(($g + 0.055) / 1.055, 2.4);
        } else {
            $g /= 12.92;
        }

        if ($b > 0.04045) {
            $b = pow(($b + 0.055) / 1.055, 2.4);
        } else {
            $b /= 12.92;
        }

        $r *= 100;
        $g *= 100;
        $b *= 100;

        $x = round($r * 0.4124 + $g * 0.3576 + $b * 0.1805, self::PRECISSION);
        $y = round($r * 0.2126 + $g * 0.7152 + $b * 0.0722, self::PRECISSION);
        $z = round($r * 0.0193 + $g * 0.1192 + $b * 0.9505, self::PRECISSION);

        if ($x >= 95.047) {
            $x = 95.047;
        }

        if ($y >= 100) {
            $y = 100;
        }

        if ($z >= 108.883) {
            $z = 108.883;
        }

        return new ColorXYZ($x, $y, $z);
    }
}
