<?php

declare(strict_types=1);

namespace Coloreeze;

use Coloreeze\Interfaces\Color as ColorInterface;

final class ColorInt extends Color implements ColorInterface
{
    public const VALUE_MAX = 4294967295;
    public const VALUE_MIN = 0;

    public function __construct(
        private readonly int $value
    ) {
        self::validateIsInRange(
            $this->value,
            self::VALUE_MIN,
            self::VALUE_MAX,
            'ColorInt'
        );
    }

    public function __toString(): string
    {
        return sprintf(
            'int(%d)',
            $this->value
        );
    }

    public function adjustBrightness(int $steps = 1): ColorInt
    {
        return $this->toRGBA()->adjustBrightness($steps)->toInt();
    }

    public function distanceCIE76(ColorInterface $color): float
    {
        return $this->toCIELab()->distanceCIE76($color->toCIELab());
    }

    public static function fromString(string $value): ColorInt
    {
        self::validateFormat($value, self::class);

        preg_match(self::MAP_REGEXP[self::class], $value, $matches);

        return new static((int) $matches[1]);
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function toCIELab(): ColorCIELab
    {
        return $this->toXYZ()->toCIELab();
    }

    public function toCMYK(): ColorCMYK
    {
        return $this->toHex()->toCMYK();
    }

    public function toComplementary(): ColorInt
    {
        return $this->toRGBA()->toComplementary()->toInt();
    }

    public function toGreyscale(): ColorInt
    {
        return $this->toRGBA()->toGreyscale()->toInt();
    }

    public function toHex(): ColorHex
    {
        return new ColorHex(
            str_pad(dechex($this->value), 8, '0', STR_PAD_LEFT)
        );
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
        return $this;
    }

    public function toRGBA(): ColorRGBA
    {
        return $this->toHex()->toRGBA();
    }

    public function toXYZ(): ColorXYZ
    {
        return $this->toRGBA()->toXYZ();
    }
}
