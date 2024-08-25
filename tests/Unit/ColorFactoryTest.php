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
     * @covers \Coloreeze\ColorFactory::fromString
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateFormat
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorCIELab::fromString
     * @covers \Coloreeze\ColorCMYK::fromString
     * @covers \Coloreeze\ColorHSB::fromString
     * @covers \Coloreeze\ColorHSL::fromString
     * @covers \Coloreeze\ColorHex::fromString
     * @covers \Coloreeze\ColorInt::fromString
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::fromString
     * @covers \Coloreeze\ColorXYZ::fromString
     * @covers \Coloreeze\Exceptions\InvalidInput::notInRange
     * @covers \Coloreeze\Exceptions\InvalidInput::notMatchingAnyColor
     * @covers \Coloreeze\Exceptions\InvalidInput::wrongFormat
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
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateFormat
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorCIELab::__construct
     * @covers \Coloreeze\ColorCIELab::fromString
     * @covers \Coloreeze\ColorCMYK::__construct
     * @covers \Coloreeze\ColorCMYK::fromString
     * @covers \Coloreeze\ColorFactory::fromString
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorHex::fromString
     * @covers \Coloreeze\ColorHSB::__construct
     * @covers \Coloreeze\ColorHSB::fromString
     * @covers \Coloreeze\ColorHSL::__construct
     * @covers \Coloreeze\ColorHSL::fromString
     * @covers \Coloreeze\ColorInt::__construct
     * @covers \Coloreeze\ColorInt::fromString
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::fromString
     * @covers \Coloreeze\ColorXYZ::__construct
     * @covers \Coloreeze\ColorXYZ::fromString
     * @covers \Coloreeze\Exceptions\InvalidInput::wrongFormat
     *
     * @dataProvider dataProviderValidInput
     */
    public function testWithValidInput(string $input, string $expectedClass): void
    {
        $sut = ColorFactory::fromString($input);

        static::assertSame($expectedClass, get_class($sut));
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
