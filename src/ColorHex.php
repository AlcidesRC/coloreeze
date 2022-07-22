<?php

declare(strict_types=1);

namespace Fonil\Coloreeze;

use Fonil\Coloreeze\Interfaces\Color as ColorInterface;

final class ColorHex extends Color implements ColorInterface
{
    private const DASH = '#';
    private const DEFAULT__ALPHA = 'FF';

    /**
     * @var array<string, int>
     */
    private readonly array $channels;

    private readonly string $value;

    public function __construct(string $value)
    {
        self::validateFormat($value, self::class);

        $value = strtoupper(ltrim($value, self::DASH));

        $this->value = match (strlen($value)) {
            6       => $value . self::DEFAULT__ALPHA,
            default => $value,
        };

        $r = substr($this->value, 0, 2);
        $g = substr($this->value, 2, 2);
        $b = substr($this->value, 4, 2);
        $a = substr($this->value, 6, 2);

        $this->channels = [
            'r' => (int) hexdec($r),
            'g' => (int) hexdec($g),
            'b' => (int) hexdec($b),
            'a' => (int) floor(hexdec($a) / 255),
        ];
    }

    public function __toString(): string
    {
        return self::DASH . $this->value;
    }

    public function adjustBrightness(int $steps = 1): ColorHex
    {
        return $this->toRGBA()->adjustBrightness($steps)->toHex();
    }

    public function distanceCIE76(ColorInterface $color): float
    {
        return $this->toCIELab()->distanceCIE76($color->toCIELab());
    }

    public static function fromString(string $value): ColorHex
    {
        self::validateFormat($value, self::class);

        preg_match(self::MAP_REGEXP[self::class], $value, $matches);

        return new static((string) $matches[1]);
    }

    public function getValue(): mixed
    {
        return self::DASH . $this->value;
    }

    public function toCIELab(): ColorCIELab
    {
        return $this->toXYZ()->toCIELab();
    }

    public function toCMYK(): ColorCMYK
    {
        $r = $this->channels['r'] / ColorRGBA::VALUE_MAX__RED;
        $g = $this->channels['g'] / ColorRGBA::VALUE_MAX__GREEN;
        $b = $this->channels['b'] / ColorRGBA::VALUE_MAX__BLUE;

        $k = 1 - max($r, $g, $b);

        if ($k === 1) {
            return new ColorCMYK(0, 0, 0, 1);
        }

        $c = (1 - $r - $k) / (1 - $k);
        $m = (1 - $g - $k) / (1 - $k);
        $y = (1 - $b - $k) / (1 - $k);

        return new ColorCMYK(
            round($c, self::PRECISSION),
            round($m, self::PRECISSION),
            round($y, self::PRECISSION),
            round($k, self::PRECISSION)
        );
    }

    public function toComplementary(): ColorHex
    {
        return $this->toRGBA()->toComplementary()->toHex();
    }

    public function toGreyscale(): ColorHex
    {
        return $this->toRGBA()->toGreyscale()->toHex();
    }

    public function toHex(): ColorHex
    {
        return $this;
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
        return new ColorInt((int) hexdec($this->value));
    }

    public function toRGBA(): ColorRGBA
    {
        return new ColorRGBA(
            $this->channels['r'],
            $this->channels['g'],
            $this->channels['b'],
            $this->channels['a']
        );
    }

    public function toXYZ(): ColorXYZ
    {
        return $this->toRGBA()->toXYZ();
    }
}
