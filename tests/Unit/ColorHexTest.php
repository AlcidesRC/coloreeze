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
final class ColorHexTest extends TestCase
{
    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForValidation')]
    public function testValidation(string $inputValue): void
    {
        static::expectException(InvalidInput::class);

        new ColorHex($inputValue);
    }

    /**
     * @return array<int, array<int, string>>
     */
    public static function dataProviderForValidation(): array
    {
        return [
            [''],
            ['0'],
            ['##F'],
            ['00f'],
            ['fff'],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForEntity')]
    public function testEntity(string $inputValue, string $expectedValue): void
    {
        $sut = new ColorHex($inputValue);

        static::assertInstanceOf(ColorHex::class, $sut);
        static::assertSame($expectedValue, $sut->getValue());
    }

    /**
     * @return array<int, array<int, string|null>>
     */
    public static function dataProviderForEntity(): array
    {
        return [
            ['#0000ff', '#0000FFFF'],
            ['#000fff', '#000FFFFF'],
            ['#00ffff', '#00FFFFFF'],
            ['#0fffff', '#0FFFFFFF'],
            ['#0fffff00', '#0FFFFF00'],
            ['#336699ff', '#336699FF'],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForFromString')]
    public function testFromString(string $inputValue, string $expectedValue): void
    {
        $sut = ColorHex::fromString($inputValue);

        static::assertInstanceOf(ColorHex::class, $sut);
        static::assertSame($expectedValue, $sut->getValue());
    }

    /**
     * @return array<int, array<int, string|null>>
     */
    public static function dataProviderForFromString(): array
    {
        return [
            ['#0000ff', '#0000FFFF'],
            ['#000fff', '#000FFFFF'],
            ['#00ffff', '#00FFFFFF'],
            ['#0fffff', '#0FFFFFFF'],
            ['#0fffff00', '#0FFFFF00'],
            ['#336699ff', '#336699FF'],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForDistanceCIE76')]
    public function testDistanceCIE76(ColorHex $input1, ColorHex $input2, float $expectedValue): void
    {
        $sut = $input1->distanceCIE76($input2);

        static::assertSame($expectedValue, $sut);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHex|float>>
     */
    public static function dataProviderForDistanceCIE76(): array
    {
        return [
            [new ColorHex('#000000'), new ColorHex('#000000'), 0],
            [new ColorHex('#000000'), new ColorHex('#FFFD9B'), 109.1308],
            [new ColorHex('#FF3E00'), new ColorHex('#003BC3'), 147.8757],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToString')]
    public function testToString(ColorHex $sut, string $expectedOutput): void
    {
        $output = (string) $sut;

        static::assertSame($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHex|string>>
     */
    public static function dataProviderForToString(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/Hex.php';

        return $sources['toString'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToHex')]
    public function testToHex(ColorHex $sut, ColorHex $expectedOutput): void
    {
        $output = $sut->toHex();

        static::assertInstanceOf(ColorHex::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHex>>
     */
    public static function dataProviderForToHex(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/Hex.php';

        return $sources['toHex'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToInt')]
    public function testToInt(ColorHex $sut, ColorInt $expectedOutput): void
    {
        $output = $sut->toInt();

        static::assertInstanceOf(ColorInt::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHex|\Coloreeze\ColorInt>>
     */
    public static function dataProviderForToInt(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/Hex.php';

        return $sources['toInt'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToRGBA')]
    public function testToRGBA(ColorHex $sut, ColorRGBA $expectedOutput): void
    {
        $output = $sut->toRGBA();

        static::assertInstanceOf(ColorRGBA::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHex|\Coloreeze\ColorRGBA>>
     */
    public static function dataProviderForToRGBA(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/Hex.php';

        return $sources['toRGBA'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToCMYK')]
    public function testToCMYK(ColorHex $sut, ColorCMYK $expectedOutput): void
    {
        $output = $sut->toCMYK();

        static::assertInstanceOf(ColorCMYK::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHex|\Coloreeze\ColorCMYK>>
     */
    public static function dataProviderForToCMYK(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/Hex.php';

        return $sources['toCMYK'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToHSL')]
    public function testToHSL(ColorHex $sut, ColorHSL $expectedOutput): void
    {
        $output = $sut->toHSL();

        static::assertInstanceOf(ColorHSL::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHex|\Coloreeze\ColorHSL>>
     */
    public static function dataProviderForToHSL(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/Hex.php';

        return $sources['toHSL'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToXYZ')]
    public function testToXYZ(ColorHex $sut, ColorXYZ $expectedOutput): void
    {
        $output = $sut->toXYZ();

        static::assertInstanceOf(ColorXYZ::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHex|\Coloreeze\ColorXYZ>>
     */
    public static function dataProviderForToXYZ(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/Hex.php';

        return $sources['toXYZ'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToHSB')]
    public function testToHSB(ColorHex $sut, ColorHSB $expectedOutput): void
    {
        $output = $sut->toHSB();

        static::assertInstanceOf(ColorHSB::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHex|\Coloreeze\ColorHSB>>
     */
    public static function dataProviderForToHSB(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/Hex.php';

        return $sources['toHSB'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToCIELab')]
    public function testToCIELab(ColorHex $sut, ColorCIELab $expectedOutput): void
    {
        $output = $sut->toCIELab();

        static::assertInstanceOf(ColorCIELab::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHex|\Coloreeze\ColorCIELab>>
     */
    public static function dataProviderForToCIELab(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/Hex.php';

        return $sources['toCIELab'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToGreyscale')]
    public function testToGreyscale(ColorHex $sut, ColorHex $expectedOutput): void
    {
        $output = $sut->toGreyscale();

        static::assertInstanceOf(ColorHex::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHex>>
     */
    public static function dataProviderForToGreyscale(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/Hex.php';

        return $sources['toGreyscale'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToComplementary')]
    public function testToComplementary(ColorHex $sut, ColorHex $expectedOutput): void
    {
        $output = $sut->toComplementary();

        static::assertInstanceOf(ColorHex::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHex>>
     */
    public static function dataProviderForToComplementary(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/Hex.php';

        return $sources['toComplementary'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToDarker')]
    public function testToDarker(ColorHex $sut, ColorHex $expectedOutput): void
    {
        $output = $sut->adjustBrightness(-25);

        static::assertInstanceOf(ColorHex::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHex>>
     */
    public static function dataProviderForToDarker(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/Hex.php';

        return $sources['toDarker'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToLighter')]
    public function testToLighter(ColorHex $sut, ColorHex $expectedOutput): void
    {
        $output = $sut->adjustBrightness(25);

        static::assertInstanceOf(ColorHex::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHex>>
     */
    public static function dataProviderForToLighter(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/Hex.php';

        return $sources['toLighter'];
    }
}
