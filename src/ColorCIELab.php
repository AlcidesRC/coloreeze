<?php

declare(strict_types=1);

namespace Coloreeze;

use Coloreeze\Interfaces\Color as ColorInterface;

final class ColorCIELab extends Color implements ColorInterface
{
    public const VALUE_MAX__A = 128;
    public const VALUE_MAX__B = 128;
    public const VALUE_MAX__L = 100;
    public const VALUE_MIN__A = -128;
    public const VALUE_MIN__B = -128;
    public const VALUE_MIN__L = 0;

    public function __construct(
        private readonly float $l,
        private readonly float $a,
        private readonly float $b
    ) {
        self::validateIsInRange(
            $this->l,
            self::VALUE_MIN__L,
            self::VALUE_MAX__L,
            'ColorCIELab (L)'
        );

        self::validateIsInRange(
            $this->a,
            self::VALUE_MIN__A,
            self::VALUE_MAX__A,
            'ColorCIELab (A)'
        );

        self::validateIsInRange(
            $this->b,
            self::VALUE_MIN__B,
            self::VALUE_MAX__B,
            'ColorCIELab (B)'
        );
    }

    public function __toString(): string
    {
        $l = $this->l;
        $a = $this->a;
        $b = $this->b;

        return "CIELab({$l},{$a},{$b})";
    }

    public function adjustBrightness(int $steps = 1): ColorCIELab
    {
        return $this->toRGBA()->adjustBrightness($steps)->toCIELab();
    }

    public function distanceCIE76(ColorInterface $color): float
    {
        if (strval($this) === strval($color)) {
            return 0;
        }

        $sum = 0;

        // @phpstan-ignore-next-line
        $sum += pow($this->l - $color->l, 2);

        // @phpstan-ignore-next-line
        $sum += pow($this->a - $color->a, 2);

        // @phpstan-ignore-next-line
        $sum += pow($this->b - $color->b, 2);

        return round(sqrt($sum), self::PRECISSION);
    }

    public static function fromString(string $value): ColorCIELab
    {
        self::validateFormat($value, self::class);

        preg_match(self::MAP_REGEXP[self::class], $value, $matches);

        return new static((float) $matches[1], (float) $matches[2], (float) $matches[3]);
    }

    public function getValue(): mixed
    {
        return [$this->l, $this->a, $this->b];
    }

    public function toCIELab(): ColorCIELab
    {
        return $this;
    }

    public function toCMYK(): ColorCMYK
    {
        return $this->toXYZ()->toCMYK();
    }

    public function toComplementary(): ColorCIELab
    {
        return $this->toRGBA()->toComplementary()->toCIELab();
    }

    public function toGreyscale(): ColorCIELab
    {
        return $this->toRGBA()->toGreyscale()->toCIELab();
    }

    public function toHex(): ColorHex
    {
        return $this->toXYZ()->toHex();
    }

    public function toHSB(): ColorHSB
    {
        return $this->toXYZ()->toHSB();
    }

    public function toHSL(): ColorHSL
    {
        return $this->toXYZ()->toHSL();
    }

    public function toInt(): ColorInt
    {
        return $this->toXYZ()->toInt();
    }

    public function toRGBA(): ColorRGBA
    {
        return $this->toXYZ()->toRGBA();
    }

    public function toXYZ(): ColorXYZ
    {
        $y = ($this->l + 16) / 116;
        $x = $this->a / 500 + $y;
        $z = $y - $this->b / 200;

        if (pow($y, 3) > 0.008856) {
            $y = pow($y, 3);
        } else {
            $y = ($y - 16 / 116) / 7.787;
        }

        if (pow($x, 3) > 0.008856) {
            $x = pow($x, 3);
        } else {
            $x = ($x - 16 / 116) / 7.787;
        }

        if (pow($z, 3) > 0.008856) {
            $z = pow($z, 3);
        } else {
            $z = ($z - 16 / 116) / 7.787;
        }

        $x = round(95.047 * $x, self::PRECISSION);
        $y = round(100.000 * $y, self::PRECISSION);
        $z = round(108.883 * $z, self::PRECISSION);

        /*
        if ($x >= 95.047) {
            $x = 95.047;
        }

        if ($y >= 100) {
            $y = 100;
        }

        if ($z >= 108.883) {
            $z = 108.883;
        }
        */

        return new ColorXYZ($x, $y, $z);
    }
}
