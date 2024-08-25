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
final class ColorHSLTest extends TestCase
{
    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForValidation')]
    public function testValidation(int $hue, int $saturation, int $lightness): void
    {
        static::expectException(InvalidInput::class);

        new ColorHSL($hue, $saturation, $lightness);
    }

    /**
     * @return array<int, array<int, int>>
     */
    public static function dataProviderForValidation(): array
    {
        return [
            [ColorHSL::VALUE_MIN__HUE - 1, 0, 0],
            [ColorHSL::VALUE_MAX__HUE + 1, 0, 0],
            [0, ColorHSL::VALUE_MIN__SATURATION - 1, 0],
            [0, ColorHSL::VALUE_MAX__SATURATION + 1, 0],
            [0, 0, ColorHSL::VALUE_MIN__LIGHTNESS - 1],
            [0, 0, ColorHSL::VALUE_MAX__LIGHTNESS + 1],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForEntity')]
    public function testEntity(int $hue, float $saturation, float $value, array $expectedValue): void
    {
        $sut = new ColorHSL($hue, $saturation, $value);

        static::assertInstanceOf(ColorHSL::class, $sut);
        static::assertSame($expectedValue, $sut->getValue());
    }

    /**
     * @return array<int, array<int, array<int, float>|int>>
     */
    public static function dataProviderForEntity(): array
    {
        return [
            [0, 0, 0, [0.0, 0.0, 0.0]],
            [240, 100, 3, [240.0, 100.0, 3.0]],
            [240, 100, 50, [240.0, 100.0, 50.0]],
            [236, 100, 50, [236.0, 100.0, 50.0]],
            [180, 100, 50, [180.0, 100.0, 50.0]],
            [180, 100, 53, [180.0, 100.0, 53.0]],
            [0, 0, 100, [0.0, 0.0, 100.0]],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForFromString')]
    public function testFromString(string $inputValue, array $expectedValue): void
    {
        $sut = ColorHSL::fromString($inputValue);

        static::assertInstanceOf(ColorHSL::class, $sut);
        static::assertSame($expectedValue, $sut->getValue());
    }

    /**
     * @return array<int, array<int, array<int, float>|string>>
     */
    public static function dataProviderForFromString(): array
    {
        return [
            ['hsl(0,0,0)', [0.0000, 0.0000, 0.0000]],
            ['hsl(255,100,100)', [255.0000, 100.0000, 100.0000]],
            ['hsl(0,0%,0%)', [0.0000, 0.0000, 0.0000]],
            ['hsl(255,100%,100%)', [255.0000, 100.0000, 100.0000]],
            ['hsl(33,66,99)', [33.0000, 66.0000, 99.0000]],
            ['hsl(33,66%,99%)', [33.0000, 66.0000, 99.0000]],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForDistanceCIE76')]
    public function testDistanceCIE76(ColorHSL $input1, ColorHSL $input2, float $expectedValue): void
    {
        $sut = $input1->distanceCIE76($input2);

        static::assertSame($expectedValue, $sut);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHSL|float>>
     */
    public static function dataProviderForDistanceCIE76(): array
    {
        return [
            [new ColorHSL(0, 0, 0), new ColorHSL(0, 0, 0), 0],
            [new ColorHSL(0, 0, 0), new ColorHSL(59, 100, 80), 109.5367],
            [new ColorHSL(15, 100, 50), new ColorHSL(222, 100, 38), 147.8561],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToString')]
    public function testToString(ColorHSL $sut, string $expectedOutput): void
    {
        $output = (string) $sut;

        static::assertSame($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHSL|string>>
     */
    public static function dataProviderForToString(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/HSL.php';

        return $sources['toString'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToHex')]
    public function testToHex(ColorHSL $sut, ColorHex $expectedOutput): void
    {
        $output = $sut->toHex();

        static::assertInstanceOf(ColorHex::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHSL|\Coloreeze\ColorHex>>
     */
    public static function dataProviderForToHex(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/HSL.php';

        return $sources['toHex'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToInt')]
    public function testToInt(ColorHSL $sut, ColorInt $expectedOutput): void
    {
        $output = $sut->toInt();

        static::assertInstanceOf(ColorInt::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHSL|\Coloreeze\ColorInt>>
     */
    public static function dataProviderForToInt(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/HSL.php';

        return $sources['toInt'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToRGBA')]
    public function testToRGBA(ColorHSL $sut, ColorRGBA $expectedOutput): void
    {
        $output = $sut->toRGBA();

        static::assertInstanceOf(ColorRGBA::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHSL|\Coloreeze\ColorRGBA>>
     */
    public static function dataProviderForToRGBA(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/HSL.php';

        return $sources['toRGBA'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToCMYK')]
    public function testToCMYK(ColorHSL $sut, ColorCMYK $expectedOutput): void
    {
        $output = $sut->toCMYK();

        static::assertInstanceOf(ColorCMYK::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHSL|\Coloreeze\ColorCMYK>>
     */
    public static function dataProviderForToCMYK(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/HSL.php';

        return $sources['toCMYK'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToHSL')]
    public function testToHSL(ColorHSL $sut, ColorHSL $expectedOutput): void
    {
        $output = $sut->toHSL();

        static::assertInstanceOf(ColorHSL::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHSL|\Coloreeze\ColorHSL>>
     */
    public static function dataProviderForToHSL(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/HSL.php';

        return $sources['toHSL'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToXYZ')]
    public function testToXYZ(ColorHSL $sut, ColorXYZ $expectedOutput): void
    {
        $output = $sut->toXYZ();

        static::assertInstanceOf(ColorXYZ::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHSL|\Coloreeze\ColorXYZ>>
     */
    public static function dataProviderForToXYZ(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/HSL.php';

        return $sources['toXYZ'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToHSB')]
    public function testToHSB(ColorHSL $sut, ColorHSB $expectedOutput): void
    {
        $output = $sut->toHSB();

        static::assertInstanceOf(ColorHSB::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHSL|\Coloreeze\ColorHSB>>
     */
    public static function dataProviderForToHSB(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/HSL.php';

        return $sources['toHSB'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToCIELab')]
    public function testToCIELab(ColorHSL $sut, ColorCIELab $expectedOutput): void
    {
        $output = $sut->toCIELab();

        static::assertInstanceOf(ColorCIELab::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHSL|\Coloreeze\ColorCIELab>>
     */
    public static function dataProviderForToCIELab(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/HSL.php';

        return $sources['toCIELab'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToGreyscale')]
    public function testToGreyscale(ColorHSL $sut, ColorHSL $expectedOutput): void
    {
        $output = $sut->toGreyscale();

        static::assertInstanceOf(ColorHSL::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHSL>>
     */
    public static function dataProviderForToGreyscale(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/HSL.php';

        return $sources['toGreyscale'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToComplementary')]
    public function testToComplementary(ColorHSL $sut, ColorHSL $expectedOutput): void
    {
        $output = $sut->toComplementary();

        static::assertInstanceOf(ColorHSL::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHSL>>
     */
    public static function dataProviderForToComplementary(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/HSL.php';

        return $sources['toComplementary'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToDarker')]
    public function testToDarker(ColorHSL $sut, ColorHSL $expectedOutput): void
    {
        $output = $sut->adjustBrightness(-25);

        static::assertInstanceOf(ColorHSL::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHSL>>
     */
    public static function dataProviderForToDarker(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/HSL.php';

        return $sources['toDarker'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToLighter')]
    public function testToLighter(ColorHSL $sut, ColorHSL $expectedOutput): void
    {
        $output = $sut->adjustBrightness(25);

        static::assertInstanceOf(ColorHSL::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHSL>>
     */
    public static function dataProviderForToLighter(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/HSL.php';

        return $sources['toLighter'];
    }
}
