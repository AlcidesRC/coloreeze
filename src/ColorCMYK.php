<?php

declare(strict_types=1);

namespace Coloreeze;

use Coloreeze\Interfaces\Color as ColorInterface;

final class ColorCMYK extends Color implements ColorInterface
{
    public const VALUE_MAX__CYAN = 1;
    public const VALUE_MAX__KEY = 1;
    public const VALUE_MAX__MAGENTA = 1;
    public const VALUE_MAX__YELLOW = 1;
    public const VALUE_MIN__CYAN = 0;
    public const VALUE_MIN__KEY = 0;
    public const VALUE_MIN__MAGENTA = 0;
    public const VALUE_MIN__YELLOW = 0;

    public function __construct(
        private readonly float $cyan,
        private readonly float $magenta,
        private readonly float $yellow,
        private readonly float $key
    ) {
        self::validateIsInRange(
            $this->cyan,
            self::VALUE_MIN__CYAN,
            self::VALUE_MAX__CYAN,
            'ColorCMYK (cyan)'
        );

        self::validateIsInRange(
            $this->magenta,
            self::VALUE_MIN__MAGENTA,
            self::VALUE_MAX__MAGENTA,
            'ColorCMYK (magenta)'
        );

        self::validateIsInRange(
            $this->yellow,
            self::VALUE_MIN__YELLOW,
            self::VALUE_MAX__YELLOW,
            'ColorCMYK (yellow)'
        );

        self::validateIsInRange(
            $this->key,
            self::VALUE_MIN__KEY,
            self::VALUE_MAX__KEY,
            'ColorCMYK (key)'
        );
    }

    public function __toString(): string
    {
        $c = round($this->cyan * 100);
        $m = round($this->magenta * 100);
        $y = round($this->yellow * 100);
        $k = round($this->key * 100);

        return "cmyk({$c},{$m}%,{$y}%,{$k}%)";
    }

    public function adjustBrightness(int $steps = 1): ColorCMYK
    {
        return $this->toRGBA()->adjustBrightness($steps)->toCMYK();
    }

    public function distanceCIE76(ColorInterface $color): float
    {
        return $this->toCIELab()->distanceCIE76($color->toCIELab());
    }

    public static function fromString(string $value): ColorCMYK
    {
        self::validateFormat($value, self::class);

        preg_match(self::MAP_REGEXP[self::class], $value, $matches);

        return new static((float) $matches[1], (float) $matches[2], (float) $matches[3], (float) $matches[4]);
    }

    public function getValue(): mixed
    {
        return [$this->cyan, $this->magenta, $this->yellow, $this->key];
    }

    public function toCIELab(): ColorCIELab
    {
        return $this->toXYZ()->toCIELab();
    }

    public function toCMYK(): ColorCMYK
    {
        return $this;
    }

    public function toComplementary(): ColorCMYK
    {
        return $this->toRGBA()->toComplementary()->toCMYK();
    }

    public function toGreyscale(): ColorCMYK
    {
        return $this->toRGBA()->toGreyscale()->toCMYK();
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
        return $this->toRGBA()->toInt();
    }

    public function toRGBA(): ColorRGBA
    {
        $r = floor(255 * (1 - $this->cyan) * (1 - $this->key));
        $g = floor(255 * (1 - $this->magenta) * (1 - $this->key));
        $b = floor(255 * (1 - $this->yellow) * (1 - $this->key));

        return new ColorRGBA(
            (int) round($r, 0),
            (int) round($g, 0),
            (int) round($b, 0)
        );
    }

    public function toXYZ(): ColorXYZ
    {
        return $this->toRGBA()->toXYZ();
    }
}
