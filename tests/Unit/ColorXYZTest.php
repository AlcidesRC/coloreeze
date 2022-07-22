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
final class ColorXYZTest extends TestCase
{
    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorXYZ::__construct
     * @covers \Fonil\Coloreeze\Exceptions\InvalidInput::notInRange
     * @covers \Fonil\Coloreeze\Color::isInRange
     *
     * @dataProvider dataProviderForValidation
     */
    public function testValidation(float $x, float $y, float $z): void
    {
        static::expectException(InvalidInput::class);

        new ColorXYZ($x, $y, $z);
    }

    /**
     * @return array<int, array<int, float|int>>
     */
    public function dataProviderForValidation(): array
    {
        return [
            [ColorXYZ::VALUE_MIN__X - 1, 0, 0],
            [ColorXYZ::VALUE_MAX__X + 1, 0, 0],
            [0, ColorXYZ::VALUE_MIN__Y - 1, 0],
            [0, ColorXYZ::VALUE_MAX__Y + 1, 0],
            [0, 0, ColorXYZ::VALUE_MIN__Z - 1],
            [0, 0, ColorXYZ::VALUE_MAX__Z + 1],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @param array<int, array<int, array<int, float>|float|int>> $expectedValue
     *
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorXYZ::__construct
     * @covers \Fonil\Coloreeze\ColorXYZ::getValue
     * @covers \Fonil\Coloreeze\Color::isInRange
     *
     * @dataProvider dataProviderForEntity
     */
    public function testEntity(int|float $x, int|float $y, int|float $z, array $expectedValue): void
    {
        $sut = new ColorXYZ($x, $y, $z);

        static::assertInstanceOf(ColorXYZ::class, $sut);
        static::assertSame($expectedValue, $sut->getValue());
    }

    /**
     * @return array<int, array<int, array<int, float>|float|int>>
     */
    public function dataProviderForEntity(): array
    {
        return [
            [0, 0, 0, [0.0, 0.0, 0.0]],
            [0.086, 0.034, 0.454, [0.086, 0.034, 0.454]],
            [18.05, 7.22, 95.05, [18.05, 7.22, 95.05]],
            [18.221, 7.562, 95.107, [18.221, 7.562, 95.107]],
            [53.81, 78.74, 106.97, [53.81, 78.74, 106.97]],
            [54.007, 78.842, 106.979, [54.007, 78.842, 106.979]],
            [95.047, 100, 108.883, [95.047, 100.0, 108.883]],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @param array<int, array<int, array<int, float>|string>> $expectedValue
     *
     * @covers \Fonil\Coloreeze\ColorXYZ::__construct
     * @covers \Fonil\Coloreeze\ColorXYZ::fromString
     * @covers \Fonil\Coloreeze\ColorXYZ::getValue
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForFromString
     */
    public function testFromString(string $inputValue, array $expectedValue): void
    {
        $sut = ColorXYZ::fromString($inputValue);

        static::assertInstanceOf(ColorXYZ::class, $sut);
        static::assertSame($expectedValue, $sut->getValue());
    }

    /**
     * @return array<int, array<int, array<int, float>|string>>
     */
    public function dataProviderForFromString(): array
    {
        return [
            ['xyz(0,0,0)', [0.0000, 0.0000, 0.0000]],
            ['xyz(95,100,100)', [95.0000, 100.0000, 100.0000]],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorCIELab::__construct
     * @covers \Fonil\Coloreeze\ColorCIELab::__toString
     * @covers \Fonil\Coloreeze\ColorCIELab::distanceCIE76
     * @covers \Fonil\Coloreeze\ColorXYZ::distanceCIE76
     * @covers \Fonil\Coloreeze\ColorXYZ::toCIELab
     *
     * @dataProvider dataProviderForDistanceCIE76
     */
    public function testDistanceCIE76(ColorXYZ $input1, ColorXYZ $input2, float $expectedValue): void
    {
        $sut = $input1->distanceCIE76($input2);

        static::assertSame($expectedValue, $sut);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorXYZ|float>>
     */
    public function dataProviderForDistanceCIE76(): array
    {
        return [
            [new ColorXYZ(0.000, 0.000, 0.000), new ColorXYZ(0.000, 0.000, 0.000), 0],
            [new ColorXYZ(0.000, 0.000, 0.000), new ColorXYZ(82.283, 93.879, 44.790), 109.134],
            [new ColorXYZ(42.968, 24.712, 2.508), new ColorXYZ(11.411, 7.066, 52.382), 147.857],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\ColorXYZ::__construct
     * @covers \Fonil\Coloreeze\ColorXYZ::__toString
     *
     * @dataProvider dataProviderForToString
     */
    public function testToString(ColorXYZ $sut, string $expectedOutput): void
    {
        $output = (string) $sut;

        static::assertSame($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorXYZ|string>>
     */
    public function dataProviderForToString(): array
    {
        $sources = include __DIR__ . '/DataSources/XYZ.php';

        return $sources['toString'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorHex::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::toHex
     * @covers \Fonil\Coloreeze\ColorXYZ::__construct
     * @covers \Fonil\Coloreeze\ColorXYZ::toHex
     * @covers \Fonil\Coloreeze\ColorXYZ::toRGBA
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForToHex
     */
    public function testToHex(ColorXYZ $sut, ColorHex $expectedOutput): void
    {
        $output = $sut->toHex();

        static::assertInstanceOf(ColorHex::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorXYZ|\Fonil\Coloreeze\ColorHex>>
     */
    public function dataProviderForToHex(): array
    {
        $sources = include __DIR__ . '/DataSources/XYZ.php';

        return $sources['toHex'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorHex::__construct
     * @covers \Fonil\Coloreeze\ColorHex::toInt
     * @covers \Fonil\Coloreeze\ColorInt::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::toHex
     * @covers \Fonil\Coloreeze\ColorRGBA::toInt
     * @covers \Fonil\Coloreeze\ColorXYZ::__construct
     * @covers \Fonil\Coloreeze\ColorXYZ::toInt
     * @covers \Fonil\Coloreeze\ColorXYZ::toInt
     * @covers \Fonil\Coloreeze\ColorXYZ::toRGBA
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForToInt
     */
    public function testToInt(ColorXYZ $sut, ColorInt $expectedOutput): void
    {
        $output = $sut->toInt();

        static::assertInstanceOf(ColorInt::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorXYZ|\Fonil\Coloreeze\ColorInt>>
     */
    public function dataProviderForToInt(): array
    {
        $sources = include __DIR__ . '/DataSources/XYZ.php';

        return $sources['toInt'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorHex::__construct
     * @covers \Fonil\Coloreeze\ColorHex::toRGBA
     * @covers \Fonil\Coloreeze\ColorInt::__construct
     * @covers \Fonil\Coloreeze\ColorInt::toHex
     * @covers \Fonil\Coloreeze\ColorInt::toRGBA
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorXYZ::toRGBA
     * @covers \Fonil\Coloreeze\Color::isInRange
     *
     * @dataProvider dataProviderForToRGBA
     */
    public function testToRGBA(ColorXYZ $sut, ColorRGBA $expectedOutput): void
    {
        $output = $sut->toRGBA();

        static::assertInstanceOf(ColorRGBA::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorXYZ|\Fonil\Coloreeze\ColorRGBA>>
     */
    public function dataProviderForToRGBA(): array
    {
        $sources = include __DIR__ . '/DataSources/XYZ.php';

        return $sources['toRGBA'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorCMYK::__construct
     * @covers \Fonil\Coloreeze\ColorHex::__construct
     * @covers \Fonil\Coloreeze\ColorHex::toCMYK
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::toHex
     * @covers \Fonil\Coloreeze\ColorXYZ::toCMYK
     * @covers \Fonil\Coloreeze\ColorXYZ::toRGBA
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForToCMYK
     */
    public function testToCMYK(ColorXYZ $sut, ColorCMYK $expectedOutput): void
    {
        $output = $sut->toCMYK();

        static::assertInstanceOf(ColorCMYK::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorXYZ|\Fonil\Coloreeze\ColorCMYK>>
     */
    public function dataProviderForToCMYK(): array
    {
        $sources = include __DIR__ . '/DataSources/XYZ.php';

        return $sources['toCMYK'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorXYZ::__construct
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\ColorHSL::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::toHSL
     * @covers \Fonil\Coloreeze\ColorXYZ::toHSL
     * @covers \Fonil\Coloreeze\ColorXYZ::toRGBA
     *
     * @dataProvider dataProviderForToHSL
     */
    public function testToHSL(ColorXYZ $sut, ColorHSL $expectedOutput): void
    {
        $output = $sut->toHSL();

        static::assertInstanceOf(ColorHSL::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorXYZ|\Fonil\Coloreeze\ColorHSL>>
     */
    public function dataProviderForToHSL(): array
    {
        $sources = include __DIR__ . '/DataSources/XYZ.php';

        return $sources['toHSL'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorXYZ::__construct
     * @covers \Fonil\Coloreeze\ColorXYZ::toXYZ
     * @covers \Fonil\Coloreeze\Color::isInRange
     *
     * @dataProvider dataProviderForToXYZ
     */
    public function testToXYZ(ColorXYZ $sut, ColorXYZ $expectedOutput): void
    {
        $output = $sut->toXYZ();

        static::assertInstanceOf(ColorXYZ::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorXYZ|\Fonil\Coloreeze\ColorXYZ>>
     */
    public function dataProviderForToXYZ(): array
    {
        $sources = include __DIR__ . '/DataSources/XYZ.php';

        return $sources['toXYZ'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorHSB::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::toHSB
     * @covers \Fonil\Coloreeze\ColorXYZ::__construct
     * @covers \Fonil\Coloreeze\ColorXYZ::toHSB
     * @covers \Fonil\Coloreeze\ColorXYZ::toRGBA
     *
     * @dataProvider dataProviderForToHSB
     */
    public function testToHSB(ColorXYZ $sut, ColorHSB $expectedOutput): void
    {
        $output = $sut->toHSB();

        static::assertInstanceOf(ColorHSB::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorXYZ|\Fonil\Coloreeze\ColorHSB>>
     */
    public function dataProviderForToHSB(): array
    {
        $sources = include __DIR__ . '/DataSources/XYZ.php';

        return $sources['toHSB'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorXYZ::__construct
     * @covers \Fonil\Coloreeze\ColorXYZ::toCIELab
     * @covers \Fonil\Coloreeze\ColorCIELab::__construct
     *
     * @dataProvider dataProviderForToCIELab
     */
    public function testToCIELab(ColorXYZ $sut, ColorCIELab $expectedOutput): void
    {
        $output = $sut->toCIELab();

        static::assertInstanceOf(ColorCIELab::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorXYZ|\Fonil\Coloreeze\ColorCIELab>>
     */
    public function dataProviderForToCIELab(): array
    {
        $sources = include __DIR__ . '/DataSources/XYZ.php';

        return $sources['toCIELab'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::toGreyscale
     * @covers \Fonil\Coloreeze\ColorRGBA::toXYZ
     * @covers \Fonil\Coloreeze\ColorXYZ::__construct
     * @covers \Fonil\Coloreeze\ColorXYZ::toGreyscale
     * @covers \Fonil\Coloreeze\ColorXYZ::toRGBA
     *
     * @dataProvider dataProviderForToGreyscale
     */
    public function testToGreyscale(ColorXYZ $sut, ColorXYZ $expectedOutput): void
    {
        $output = $sut->toGreyscale();

        static::assertInstanceOf(ColorXYZ::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorXYZ>>
     */
    public function dataProviderForToGreyscale(): array
    {
        $sources = include __DIR__ . '/DataSources/XYZ.php';

        return $sources['toGreyscale'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorXYZ::__construct
     * @covers \Fonil\Coloreeze\ColorXYZ::toComplementary
     * @covers \Fonil\Coloreeze\ColorXYZ::toRGBA
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::toComplementary
     * @covers \Fonil\Coloreeze\ColorRGBA::toXYZ
     *
     * @dataProvider dataProviderForToComplementary
     */
    public function testToComplementary(ColorXYZ $sut, ColorXYZ $expectedOutput): void
    {
        $output = $sut->toComplementary();

        static::assertInstanceOf(ColorXYZ::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorXYZ>>
     */
    public function dataProviderForToComplementary(): array
    {
        $sources = include __DIR__ . '/DataSources/XYZ.php';

        return $sources['toComplementary'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorXYZ::__construct
     * @covers \Fonil\Coloreeze\ColorXYZ::adjustBrightness
     * @covers \Fonil\Coloreeze\ColorXYZ::toRGBA
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::adjustBrightness
     * @covers \Fonil\Coloreeze\ColorRGBA::toXYZ
     *
     * @dataProvider dataProviderForToDarker
     */
    public function testToDarker(ColorXYZ $sut, ColorXYZ $expectedOutput): void
    {
        $output = $sut->adjustBrightness(-25);

        static::assertInstanceOf(ColorXYZ::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorXYZ>>
     */
    public function dataProviderForToDarker(): array
    {
        $sources = include __DIR__ . '/DataSources/XYZ.php';

        return $sources['toDarker'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorXYZ::__construct
     * @covers \Fonil\Coloreeze\ColorXYZ::adjustBrightness
     * @covers \Fonil\Coloreeze\ColorXYZ::toRGBA
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::adjustBrightness
     * @covers \Fonil\Coloreeze\ColorRGBA::toXYZ
     *
     * @dataProvider dataProviderForToLighter
     */
    public function testToLighter(ColorXYZ $sut, ColorXYZ $expectedOutput): void
    {
        $output = $sut->adjustBrightness(25);

        static::assertInstanceOf(ColorXYZ::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorXYZ>>
     */
    public function dataProviderForToLighter(): array
    {
        $sources = include __DIR__ . '/DataSources/XYZ.php';

        return $sources['toLighter'];
    }
}
