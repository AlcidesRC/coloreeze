<?php

namespace UnitTests;

use Coloreeze\ColorCIELab;
use Coloreeze\ColorCMYK;
use Coloreeze\ColorFactory;
use Coloreeze\ColorHex;
use Coloreeze\ColorHSB;
use Coloreeze\ColorHSL;
use Coloreeze\ColorInt;
use Coloreeze\ColorRGBA;
use Coloreeze\ColorXYZ;
use Coloreeze\Exceptions\InvalidInput;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(\Coloreeze\ColorCIELab::class)]
#[CoversClass(\Coloreeze\ColorCMYK::class)]
#[CoversClass(\Coloreeze\ColorFactory::class)]
#[CoversClass(\Coloreeze\ColorHSB::class)]
#[CoversClass(\Coloreeze\ColorHSL::class)]
#[CoversClass(\Coloreeze\ColorHex::class)]
#[CoversClass(\Coloreeze\ColorInt::class)]
#[CoversClass(\Coloreeze\ColorRGBA::class)]
#[CoversClass(\Coloreeze\ColorXYZ::class)]
#[CoversClass(\Coloreeze\Exceptions\InvalidInput::class)]
final class ColorFactoryTest extends TestCase
{
    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderUnvalidInput')]
    public function testWithUnvalidInput(string $input): void
    {
        static::expectException(InvalidInput::class);

        ColorFactory::fromString($input);
    }

    /**
     * @return array<int, array<int, string>>
     */
    public static function dataProviderUnvalidInput(): array
    {
        return [
            [''],
            ['unknown(1,2,3)'],
            ['rgba(0,0,0,99999)'],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderValidInput')]
    public function testWithValidInput(string $input, string $expectedClass): void
    {
        $sut = ColorFactory::fromString($input);

        static::assertSame($expectedClass, get_class($sut));
    }

    /**
     * @return array<int, array<int, string>>
     */
    public static function dataProviderValidInput(): array
    {
        return [
            ['cielab(0,0,0)', ColorCIELab::class],
            ['cielab(.11,.22,.333)', ColorCIELab::class],
            ['cielab(0.11,0.22,0.333)', ColorCIELab::class],
            ['cielab(100,-110,-110)', ColorCIELab::class],
            ['cielab(100,-100.123,-100.123)', ColorCIELab::class],

            ['cmyk(0,0,0,0)', ColorCMYK::class],
            ['cmyk(.11,.22,.33,.44)', ColorCMYK::class],
            ['cmyk(0.11,0.22,0.33,0.44)', ColorCMYK::class],

            ['#FFFFFF', ColorHex::class],
            ['#336699FF', ColorHex::class],

            ['hsb(0,0,0)', ColorHSB::class],
            ['hsb(360,100,100)', ColorHSB::class],
            ['hsb(100.1,99.2,99.3)', ColorHSB::class],

            ['hsl(0,0,0)', ColorHSL::class],
            ['hsl(100,100,100)', ColorHSL::class],
            ['hsl(99.1,99.2,99.3)', ColorHSL::class],

            ['int(0)', ColorInt::class],
            ['int(100)', ColorInt::class],
            ['int(12345)', ColorInt::class],

            ['rgba(1,2,3)', ColorRGBA::class],
            ['rgba(1,2,3,0)', ColorRGBA::class],
            ['rgba(1,2,3,.1)', ColorRGBA::class],
            ['rgba(1,2,3,0.99)', ColorRGBA::class],

            ['xyz(0,0,0)', ColorXYZ::class],
            ['xyz(.11,.22,.333)', ColorXYZ::class],
            ['xyz(0.11,0.22,0.333)', ColorXYZ::class],
            ['xyz(95,0,108)', ColorXYZ::class],
            ['xyz(95,100,0)', ColorXYZ::class],
        ];
    }
}
