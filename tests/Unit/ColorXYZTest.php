<?php

namespace UnitTests;

use Coloreeze\ColorCIELab;
use Coloreeze\ColorCMYK;
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
#[CoversClass(\Coloreeze\ColorHSB::class)]
#[CoversClass(\Coloreeze\ColorHSL::class)]
#[CoversClass(\Coloreeze\ColorHex::class)]
#[CoversClass(\Coloreeze\ColorInt::class)]
#[CoversClass(\Coloreeze\ColorRGBA::class)]
#[CoversClass(\Coloreeze\ColorXYZ::class)]
#[CoversClass(\Coloreeze\Exceptions\InvalidInput::class)]
final class ColorXYZTest extends TestCase
{
    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForValidation')]
    public function testValidation(float $x, float $y, float $z): void
    {
        static::expectException(InvalidInput::class);

        new ColorXYZ($x, $y, $z);
    }

    /**
     * @return array<int, array<int, float|int>>
     */
    public static function dataProviderForValidation(): array
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

    #[Test]
    #[DataProvider('dataProviderForEntity')]
    public function testEntity(int|float $x, int|float $y, int|float $z, array $expectedValue): void
    {
        $sut = new ColorXYZ($x, $y, $z);

        static::assertInstanceOf(ColorXYZ::class, $sut);
        static::assertSame($expectedValue, $sut->getValue());
    }

    /**
     * @return array<int, array<int, array<int, float>|float|int>>
     */
    public static function dataProviderForEntity(): array
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

    #[Test]
    #[DataProvider('dataProviderForFromString')]
    public function testFromString(string $inputValue, array $expectedValue): void
    {
        $sut = ColorXYZ::fromString($inputValue);

        static::assertInstanceOf(ColorXYZ::class, $sut);
        static::assertSame($expectedValue, $sut->getValue());
    }

    /**
     * @return array<int, array<int, array<int, float>|string>>
     */
    public static function dataProviderForFromString(): array
    {
        return [
            ['xyz(0,0,0)', [0.0000, 0.0000, 0.0000]],
            ['xyz(95,100,100)', [95.0000, 100.0000, 100.0000]],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForDistanceCIE76')]
    public function testDistanceCIE76(ColorXYZ $input1, ColorXYZ $input2, float $expectedValue): void
    {
        $sut = $input1->distanceCIE76($input2);

        static::assertSame($expectedValue, $sut);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorXYZ|float>>
     */
    public static function dataProviderForDistanceCIE76(): array
    {
        return [
            [new ColorXYZ(0.000, 0.000, 0.000), new ColorXYZ(0.000, 0.000, 0.000), 0],
            [new ColorXYZ(0.000, 0.000, 0.000), new ColorXYZ(82.283, 93.879, 44.790), 109.134],
            [new ColorXYZ(42.968, 24.712, 2.508), new ColorXYZ(11.411, 7.066, 52.382), 147.857],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToString')]
    public function testToString(ColorXYZ $sut, string $expectedOutput): void
    {
        $output = (string) $sut;

        static::assertSame($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorXYZ|string>>
     */
    public static function dataProviderForToString(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/XYZ.php';

        return $sources['toString'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToHex')]
    public function testToHex(ColorXYZ $sut, ColorHex $expectedOutput): void
    {
        $output = $sut->toHex();

        static::assertInstanceOf(ColorHex::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorXYZ|\Coloreeze\ColorHex>>
     */
    public static function dataProviderForToHex(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/XYZ.php';

        return $sources['toHex'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToInt')]
    public function testToInt(ColorXYZ $sut, ColorInt $expectedOutput): void
    {
        $output = $sut->toInt();

        static::assertInstanceOf(ColorInt::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorXYZ|\Coloreeze\ColorInt>>
     */
    public static function dataProviderForToInt(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/XYZ.php';

        return $sources['toInt'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToRGBA')]
    public function testToRGBA(ColorXYZ $sut, ColorRGBA $expectedOutput): void
    {
        $output = $sut->toRGBA();

        static::assertInstanceOf(ColorRGBA::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorXYZ|\Coloreeze\ColorRGBA>>
     */
    public static function dataProviderForToRGBA(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/XYZ.php';

        return $sources['toRGBA'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToCMYK')]
    public function testToCMYK(ColorXYZ $sut, ColorCMYK $expectedOutput): void
    {
        $output = $sut->toCMYK();

        static::assertInstanceOf(ColorCMYK::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorXYZ|\Coloreeze\ColorCMYK>>
     */
    public static function dataProviderForToCMYK(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/XYZ.php';

        return $sources['toCMYK'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToHSL')]
    public function testToHSL(ColorXYZ $sut, ColorHSL $expectedOutput): void
    {
        $output = $sut->toHSL();

        static::assertInstanceOf(ColorHSL::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorXYZ|\Coloreeze\ColorHSL>>
     */
    public static function dataProviderForToHSL(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/XYZ.php';

        return $sources['toHSL'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToXYZ')]
    public function testToXYZ(ColorXYZ $sut, ColorXYZ $expectedOutput): void
    {
        $output = $sut->toXYZ();

        static::assertInstanceOf(ColorXYZ::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorXYZ|\Coloreeze\ColorXYZ>>
     */
    public static function dataProviderForToXYZ(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/XYZ.php';

        return $sources['toXYZ'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToHSB')]
    public function testToHSB(ColorXYZ $sut, ColorHSB $expectedOutput): void
    {
        $output = $sut->toHSB();

        static::assertInstanceOf(ColorHSB::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorXYZ|\Coloreeze\ColorHSB>>
     */
    public static function dataProviderForToHSB(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/XYZ.php';

        return $sources['toHSB'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToCIELab')]
    public function testToCIELab(ColorXYZ $sut, ColorCIELab $expectedOutput): void
    {
        $output = $sut->toCIELab();

        static::assertInstanceOf(ColorCIELab::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorXYZ|\Coloreeze\ColorCIELab>>
     */
    public static function dataProviderForToCIELab(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/XYZ.php';

        return $sources['toCIELab'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToGreyscale')]
    public function testToGreyscale(ColorXYZ $sut, ColorXYZ $expectedOutput): void
    {
        $output = $sut->toGreyscale();

        static::assertInstanceOf(ColorXYZ::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorXYZ>>
     */
    public static function dataProviderForToGreyscale(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/XYZ.php';

        return $sources['toGreyscale'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToComplementary')]
    public function testToComplementary(ColorXYZ $sut, ColorXYZ $expectedOutput): void
    {
        $output = $sut->toComplementary();

        static::assertInstanceOf(ColorXYZ::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorXYZ>>
     */
    public static function dataProviderForToComplementary(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/XYZ.php';

        return $sources['toComplementary'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToDarker')]
    public function testToDarker(ColorXYZ $sut, ColorXYZ $expectedOutput): void
    {
        $output = $sut->adjustBrightness(-25);

        static::assertInstanceOf(ColorXYZ::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorXYZ>>
     */
    public static function dataProviderForToDarker(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/XYZ.php';

        return $sources['toDarker'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToLighter')]
    public function testToLighter(ColorXYZ $sut, ColorXYZ $expectedOutput): void
    {
        $output = $sut->adjustBrightness(25);

        static::assertInstanceOf(ColorXYZ::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorXYZ>>
     */
    public static function dataProviderForToLighter(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/XYZ.php';

        return $sources['toLighter'];
    }
}
