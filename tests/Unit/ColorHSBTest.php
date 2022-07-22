<?php

namespace UnitTests;

use Fonil\Coloreeze\ColorCIELab;
use Fonil\Coloreeze\ColorCMYK;
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
final class ColorHSBTest extends TestCase
{
    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorHSB::__construct
     * @covers \Fonil\Coloreeze\Exceptions\InvalidInput::notInRange
     * @covers \Fonil\Coloreeze\Color::isInRange
     *
     * @dataProvider dataProviderForValidation
     */
    public function testValidation(float $hue, int $saturation, int $brightness): void
    {
        static::expectException(InvalidInput::class);

        new ColorHSB($hue, $saturation, $brightness);
    }

    /**
     * @return array<int, array<int, int>>
     */
    public function dataProviderForValidation(): array
    {
        return [
            [ColorHSB::VALUE_MIN__HUE - 1, 0, 0],
            [ColorHSB::VALUE_MAX__HUE + 1, 0, 0],
            [0, ColorHSB::VALUE_MIN__SATURATION - 1, 0],
            [0, ColorHSB::VALUE_MAX__SATURATION + 1, 0],
            [0, 0, ColorHSB::VALUE_MIN__BRIGHTNESS - 1],
            [0, 0, ColorHSB::VALUE_MAX__BRIGHTNESS + 1],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @param array<int|float> $expectedValue
     *
     * @covers \Fonil\Coloreeze\ColorHSB::__construct
     * @covers \Fonil\Coloreeze\ColorHSB::getValue
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\Color::isInRange
     *
     * @dataProvider dataProviderForEntity
     */
    public function testEntity(float $hue, int $saturation, int $brightness, array $expectedValue): void
    {
        $sut = new ColorHSB($hue, $saturation, $brightness);

        static::assertInstanceOf(ColorHSB::class, $sut);
        static::assertSame($expectedValue, $sut->getValue());
    }

    /**
     * @return array<int, array<int, array<int, float>|int>>
     */
    public function dataProviderForEntity(): array
    {
        return [
            [0, 0, 0, [0.0000, 0.0000, 0.0000]],
            [240, 100, 3, [240.0000, 100.0000, 3.0000]],
            [240, 100, 50, [240.0000, 100.0000, 50.0000]],
            [236, 100, 50, [236.0000, 100.0000, 50.0000]],
            [180, 100, 50, [180.0000, 100.0000, 50.0000]],
            [180, 100, 53, [180.0000, 100.0000, 53.0000]],
            [0, 0, 100, [0.0000, 0.0000, 100.0000]],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @param array<int, array<int, array<int, float>|string>> $expectedValue
     *
     * @covers \Fonil\Coloreeze\ColorHSB::__construct
     * @covers \Fonil\Coloreeze\ColorHSB::fromString
     * @covers \Fonil\Coloreeze\ColorHSB::getValue
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForFromString
     */
    public function testFromString(string $inputValue, array $expectedValue): void
    {
        $sut = ColorHSB::fromString($inputValue);

        static::assertInstanceOf(ColorHSB::class, $sut);
        static::assertSame($expectedValue, $sut->getValue());
    }

    /**
     * @return array<int, array<int, array<int, float>|string>>
     */
    public function dataProviderForFromString(): array
    {
        return [
            ['hsb(0,0,0)', [0.0000, 0.0000, 0.0000]],
            ['hsb(255,100,100)', [255.0000, 100.0000, 100.0000]],
            ['hsb(0,0%,0%)', [0.0000, 0.0000, 0.0000]],
            ['hsb(255,100%,100%)', [255.0000, 100.0000, 100.0000]],
            ['hsb(33,66,99)', [33.0000, 66.0000, 99.0000]],
            ['hsb(33,66%,99%)', [33.0000, 66.0000, 99.0000]],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorCIELab::__construct
     * @covers \Fonil\Coloreeze\ColorCIELab::__toString
     * @covers \Fonil\Coloreeze\ColorCIELab::distanceCIE76
     * @covers \Fonil\Coloreeze\ColorHSB::distanceCIE76
     * @covers \Fonil\Coloreeze\ColorHSB::toCIELab
     * @covers \Fonil\Coloreeze\ColorHSB::toRGBA
     * @covers \Fonil\Coloreeze\ColorHSB::toXYZ
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::toXYZ
     * @covers \Fonil\Coloreeze\ColorXYZ::__construct
     * @covers \Fonil\Coloreeze\ColorXYZ::toCIELab
     *
     * @dataProvider dataProviderForDistanceCIE76
     */
    public function testDistanceCIE76(ColorHSB $input1, ColorHSB $input2, float $expectedValue): void
    {
        $sut = $input1->distanceCIE76($input2);

        static::assertSame($expectedValue, $sut);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorHSB|float>>
     */
    public function dataProviderForDistanceCIE76(): array
    {
        return [
            [new ColorHSB(0, 0, 0), new ColorHSB(0, 0, 0), 0],
            [new ColorHSB(0, 0, 0), new ColorHSB(59, 39, 100), 108.9302],
            [new ColorHSB(15, 100, 100), new ColorHSB(222, 100, 76), 147.8561],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\ColorHSB::__construct
     * @covers \Fonil\Coloreeze\ColorHSB::__toString
     *
     * @dataProvider dataProviderForToString
     */
    public function testToString(ColorHSB $sut, string $expectedOutput): void
    {
        $output = (string) $sut;

        static::assertSame($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorHSB|string>>
     */
    public function dataProviderForToString(): array
    {
        $sources = include __DIR__ . '/DataSources/HSB.php';

        return $sources['toString'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\ColorHex::__construct
     * @covers \Fonil\Coloreeze\ColorHSB::__construct
     * @covers \Fonil\Coloreeze\ColorHSB::toHex
     * @covers \Fonil\Coloreeze\ColorHSB::toRGBA
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\ColorRGBA::toHex
     * @covers \Fonil\Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForToHex
     */
    public function testToHex(ColorHSB $sut, ColorHex $expectedOutput): void
    {
        $output = $sut->toHex();

        static::assertInstanceOf(ColorHex::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorHSB|\Fonil\Coloreeze\ColorHex>>
     */
    public function dataProviderForToHex(): array
    {
        $sources = include __DIR__ . '/DataSources/HSB.php';

        return $sources['toHex'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\ColorHex::__construct
     * @covers \Fonil\Coloreeze\ColorHex::toInt
     * @covers \Fonil\Coloreeze\ColorHSB::__construct
     * @covers \Fonil\Coloreeze\ColorHSB::toHex
     * @covers \Fonil\Coloreeze\ColorHSB::toInt
     * @covers \Fonil\Coloreeze\ColorHSB::toRGBA
     * @covers \Fonil\Coloreeze\ColorInt::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::toInt
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\ColorRGBA::toHex
     * @covers \Fonil\Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForToInt
     */
    public function testToInt(ColorHSB $sut, ColorInt $expectedOutput): void
    {
        $output = $sut->toInt();

        static::assertInstanceOf(ColorInt::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorHSB|\Fonil\Coloreeze\ColorInt>>
     */
    public function dataProviderForToInt(): array
    {
        $sources = include __DIR__ . '/DataSources/HSB.php';

        return $sources['toInt'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\ColorHSB::__construct
     * @covers \Fonil\Coloreeze\ColorHSB::toRGBA
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\Color::isInRange
     *
     * @dataProvider dataProviderForToRGBA
     */
    public function testToRGBA(ColorHSB $sut, ColorRGBA $expectedOutput): void
    {
        $output = $sut->toRGBA();

        static::assertInstanceOf(ColorRGBA::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorHSB|\Fonil\Coloreeze\ColorRGBA>>
     */
    public function dataProviderForToRGBA(): array
    {
        $sources = include __DIR__ . '/DataSources/HSB.php';

        return $sources['toRGBA'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorCMYK::__construct
     * @covers \Fonil\Coloreeze\ColorHex::__construct
     * @covers \Fonil\Coloreeze\ColorHex::toCMYK
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::toCMYK
     * @covers \Fonil\Coloreeze\ColorRGBA::toHex
     * @covers Fonil\Coloreeze\ColorHSB::toCMYK
     * @covers Fonil\Coloreeze\ColorHSB::toRGBA
     * @covers \Fonil\Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForToCMYK
     */
    public function testToCMYK(ColorHSB $sut, ColorCMYK $expectedOutput): void
    {
        $output = $sut->toCMYK();

        static::assertInstanceOf(ColorCMYK::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorHSL|\Fonil\Coloreeze\ColorCMYK>>
     */
    public function dataProviderForToCMYK(): array
    {
        $sources = include __DIR__ . '/DataSources/HSB.php';

        return $sources['toCMYK'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorHSB::toHSL
     * @covers \Fonil\Coloreeze\ColorHSB::toRGBA
     * @covers \Fonil\Coloreeze\ColorHSL::__construct
     * @covers \Fonil\Coloreeze\ColorHSL::toHSL
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::toHSL
     *
     * @dataProvider dataProviderForToHSL
     */
    public function testToHSL(ColorHSB $sut, ColorHSL $expectedOutput): void
    {
        $output = $sut->toHSL();

        static::assertInstanceOf(ColorHSL::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorHSL|\Fonil\Coloreeze\ColorHSL>>
     */
    public function dataProviderForToHSL(): array
    {
        $sources = include __DIR__ . '/DataSources/HSB.php';

        return $sources['toHSL'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorHSB::__construct
     * @covers \Fonil\Coloreeze\ColorHSB::toRGBA
     * @covers \Fonil\Coloreeze\ColorHSB::toXYZ
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::toXYZ
     * @covers \Fonil\Coloreeze\ColorXYZ::__construct
     * @covers \Fonil\Coloreeze\Color::isInRange
     *
     * @dataProvider dataProviderForToXYZ
     */
    public function testToXYZ(ColorHSB $sut, ColorXYZ $expectedOutput): void
    {
        $output = $sut->toXYZ();

        static::assertInstanceOf(ColorXYZ::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorHSL|\Fonil\Coloreeze\ColorXYZ>>
     */
    public function dataProviderForToXYZ(): array
    {
        $sources = include __DIR__ . '/DataSources/HSB.php';

        return $sources['toXYZ'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorHSB::__construct
     * @covers \Fonil\Coloreeze\ColorHSB::toHSB
     *
     * @dataProvider dataProviderForToHSB
     */
    public function testToHSB(ColorHSB $sut, ColorHSB $expectedOutput): void
    {
        $output = $sut->toHSB();

        static::assertInstanceOf(ColorHSB::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorHSB|\Fonil\Coloreeze\ColorHSB>>
     */
    public function dataProviderForToHSB(): array
    {
        $sources = include __DIR__ . '/DataSources/HSB.php';

        return $sources['toHSB'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorCIELab::__construct
     * @covers \Fonil\Coloreeze\ColorHSB::toCIELab
     * @covers \Fonil\Coloreeze\ColorHSB::toRGBA
     * @covers \Fonil\Coloreeze\ColorHSB::toXYZ
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::toXYZ
     * @covers \Fonil\Coloreeze\ColorXYZ::__construct
     * @covers \Fonil\Coloreeze\ColorXYZ::toCIELab
     *
     * @dataProvider dataProviderForToCIELab
     */
    public function testToCIELab(ColorHSB $sut, ColorCIELab $expectedOutput): void
    {
        $output = $sut->toCIELab();

        static::assertInstanceOf(ColorCIELab::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorHSB|\Fonil\Coloreeze\ColorCIELab>>
     */
    public function dataProviderForToCIELab(): array
    {
        $sources = include __DIR__ . '/DataSources/HSB.php';

        return $sources['toCIELab'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorHSB::__construct
     * @covers \Fonil\Coloreeze\ColorHSB::toGreyscale
     * @covers \Fonil\Coloreeze\ColorHSB::toRGBA
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::toGreyscale
     * @covers \Fonil\Coloreeze\ColorRGBA::toHSB
     * @covers \Fonil\Coloreeze\ColorRGBA::toXYZ
     *
     * @dataProvider dataProviderForToGreyscale
     */
    public function testToGreyscale(ColorHSB $sut, ColorHSB $expectedOutput): void
    {
        $output = $sut->toGreyscale();

        static::assertInstanceOf(ColorHSB::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorHSB>>
     */
    public function dataProviderForToGreyscale(): array
    {
        $sources = include __DIR__ . '/DataSources/HSB.php';

        return $sources['toGreyscale'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorHSB::__construct
     * @covers \Fonil\Coloreeze\ColorHSB::toComplementary
     * @covers \Fonil\Coloreeze\ColorHSB::toRGBA
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::toComplementary
     * @covers \Fonil\Coloreeze\ColorRGBA::toHSB
     *
     * @dataProvider dataProviderForToComplementary
     */
    public function testToComplementary(ColorHSB $sut, ColorHSB $expectedOutput): void
    {
        $output = $sut->toComplementary();

        static::assertInstanceOf(ColorHSB::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorHSB>>
     */
    public function dataProviderForToComplementary(): array
    {
        $sources = include __DIR__ . '/DataSources/HSB.php';

        return $sources['toComplementary'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorHSB::__construct
     * @covers \Fonil\Coloreeze\ColorHSB::adjustBrightness
     * @covers \Fonil\Coloreeze\ColorHSB::toRGBA
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::adjustBrightness
     * @covers \Fonil\Coloreeze\ColorRGBA::toHSB
     *
     * @dataProvider dataProviderForToDarker
     */
    public function testToDarker(ColorHSB $sut, ColorHSB $expectedOutput): void
    {
        $output = $sut->adjustBrightness(-25);

        static::assertInstanceOf(ColorHSB::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorHSB>>
     */
    public function dataProviderForToDarker(): array
    {
        $sources = include __DIR__ . '/DataSources/HSB.php';

        return $sources['toDarker'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorHSB::__construct
     * @covers \Fonil\Coloreeze\ColorHSB::adjustBrightness
     * @covers \Fonil\Coloreeze\ColorHSB::toRGBA
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::adjustBrightness
     * @covers \Fonil\Coloreeze\ColorRGBA::toHSB
     *
     * @dataProvider dataProviderForToLighter
     */
    public function testToLighter(ColorHSB $sut, ColorHSB $expectedOutput): void
    {
        $output = $sut->adjustBrightness(25);

        static::assertInstanceOf(ColorHSB::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorHSB>>
     */
    public function dataProviderForToLighter(): array
    {
        $sources = include __DIR__ . '/DataSources/HSB.php';

        return $sources['toLighter'];
    }
}
