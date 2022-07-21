<?php

namespace UnitTests;

use Fonil\Coloreeze\ColorCIELab;
use Fonil\Coloreeze\ColorCMYK;
use Fonil\Coloreeze\ColorFactory;
use Fonil\Coloreeze\ColorHex;
use Fonil\Coloreeze\ColorHSB;
use Fonil\Coloreeze\ColorHSL;
use Fonil\Coloreeze\ColorInt;
use Fonil\Coloreeze\ColorRGBA;
use Fonil\Coloreeze\ColorXYZ;
use Fonil\Coloreeze\Exceptions\InvalidInput;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class ColorFactoryTest extends TestCase
{
    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\ColorFactory::fromString
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateFormat
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorCIELab::fromString
     * @covers \Fonil\Coloreeze\ColorCMYK::fromString
     * @covers \Fonil\Coloreeze\ColorHSB::fromString
     * @covers \Fonil\Coloreeze\ColorHSL::fromString
     * @covers \Fonil\Coloreeze\ColorHex::fromString
     * @covers \Fonil\Coloreeze\ColorInt::fromString
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::fromString
     * @covers \Fonil\Coloreeze\ColorXYZ::fromString
     * @covers \Fonil\Coloreeze\Exceptions\InvalidInput::notInRange
     * @covers \Fonil\Coloreeze\Exceptions\InvalidInput::notMatchingAnyColor
     * @covers \Fonil\Coloreeze\Exceptions\InvalidInput::wrongFormat
     *
     * @dataProvider dataProviderUnvalidInput
     */
    public function testWithUnvalidInput(string $input): void
    {
        static::expectException(InvalidInput::class);

        ColorFactory::fromString($input);
    }

    /**
     * @return array<int, array<int, string>>
     */
    public function dataProviderUnvalidInput(): array
    {
        return [
            [''],
            ['unknown(1,2,3)'],
            ['rgba(0,0,0,99999)'],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateFormat
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorCIELab::__construct
     * @covers \Fonil\Coloreeze\ColorCIELab::fromString
     * @covers \Fonil\Coloreeze\ColorCMYK::__construct
     * @covers \Fonil\Coloreeze\ColorCMYK::fromString
     * @covers \Fonil\Coloreeze\ColorFactory::fromString
     * @covers \Fonil\Coloreeze\ColorHex::__construct
     * @covers \Fonil\Coloreeze\ColorHex::fromString
     * @covers \Fonil\Coloreeze\ColorHSB::__construct
     * @covers \Fonil\Coloreeze\ColorHSB::fromString
     * @covers \Fonil\Coloreeze\ColorHSL::__construct
     * @covers \Fonil\Coloreeze\ColorHSL::fromString
     * @covers \Fonil\Coloreeze\ColorInt::__construct
     * @covers \Fonil\Coloreeze\ColorInt::fromString
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::fromString
     * @covers \Fonil\Coloreeze\ColorXYZ::__construct
     * @covers \Fonil\Coloreeze\ColorXYZ::fromString
     * @covers \Fonil\Coloreeze\Exceptions\InvalidInput::wrongFormat
     *
     * @dataProvider dataProviderValidInput
     */
    public function testWithValidInput(string $input, string $expectedClass): void
    {
        $sut = ColorFactory::fromString($input);

        static::assertInstanceOf($expectedClass, $sut);
    }

    /**
     * @return array<int, array<int, string>>
     */
    public function dataProviderValidInput(): array
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
