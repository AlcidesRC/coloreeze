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
final class ColorIntTest extends TestCase
{
    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForValidation')]
    public function testValidation(int $inputValue): void
    {
        static::expectException(InvalidInput::class);

        new ColorInt($inputValue);
    }

    /**
     * @return array<int, array<int, int>>
     */
    public static function dataProviderForValidation(): array
    {
        return [
            [ColorInt::VALUE_MIN - 1],
            [ColorInt::VALUE_MAX + 1],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForEntity')]
    public function testEntity(int $inputValue, int $expectedValue): void
    {
        $sut = new ColorInt($inputValue);

        static::assertInstanceOf(ColorInt::class, $sut);
        static::assertSame($expectedValue, $sut->getValue());
    }

    /**
     * @return array<int, array<int, int>>
     */
    public static function dataProviderForEntity(): array
    {
        return [
            [ColorInt::VALUE_MIN, ColorInt::VALUE_MIN],
            [ColorInt::VALUE_MAX, ColorInt::VALUE_MAX],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForFromString')]
    public function testFromString(string $inputValue, int $expectedValue): void
    {
        $sut = ColorInt::fromString($inputValue);

        static::assertInstanceOf(ColorInt::class, $sut);
        static::assertSame($expectedValue, $sut->getValue());
    }

    /**
     * @return array<int, array<int, int|string>>
     */
    public static function dataProviderForFromString(): array
    {
        return [
            ['int(0)', ColorInt::VALUE_MIN],
            ['int(255)', 255],
            ['int(123456)', 123456],
            ['int(4294967295)', ColorInt::VALUE_MAX],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForDistanceCIE76')]
    public function testDistanceCIE76(ColorInt $input1, ColorInt $input2, float $expectedValue): void
    {
        $sut = $input1->distanceCIE76($input2);

        static::assertSame($expectedValue, $sut);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorInt|float>>
     */
    public static function dataProviderForDistanceCIE76(): array
    {
        return [
            [new ColorInt(255), new ColorInt(255), 0],
            [new ColorInt(255), new ColorInt(4294810623), 109.1308],
            [new ColorInt(4282253567), new ColorInt(3916799), 147.8757],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToString')]
    public function testToString(ColorInt $sut, string $expectedOutput): void
    {
        $output = (string) $sut;

        static::assertSame($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorInt|string>>
     */
    public static function dataProviderForToString(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/Int.php';

        return $sources['toString'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToHex')]
    public function testToHex(ColorInt $sut, ColorHex $expectedOutput): void
    {
        $output = $sut->toHex();

        static::assertInstanceOf(ColorHex::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorInt|\Coloreeze\ColorHex>>
     */
    public static function dataProviderForToHex(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/Int.php';

        return $sources['toHex'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToInt')]
    public function testToInt(ColorInt $sut, ColorInt $expectedOutput): void
    {
        $output = $sut->toInt();

        static::assertInstanceOf(ColorInt::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorInt|\Coloreeze\ColorInt>>
     */
    public static function dataProviderForToInt(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/Int.php';

        return $sources['toInt'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToRGBA')]
    public function testToRGBA(ColorInt $sut, ColorRGBA $expectedOutput): void
    {
        $output = $sut->toRGBA();

        static::assertInstanceOf(ColorRGBA::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorInt|\Coloreeze\ColorRGBA>>
     */
    public static function dataProviderForToRGBA(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/Int.php';

        return $sources['toRGBA'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToCMYK')]
    public function testToCMYK(ColorInt $sut, ColorCMYK $expectedOutput): void
    {
        $output = $sut->toCMYK();

        static::assertInstanceOf(ColorCMYK::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorInt|\Coloreeze\ColorCMYK>>
     */
    public static function dataProviderForToCMYK(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/Int.php';

        return $sources['toCMYK'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToHSL')]
    public function testToHSL(ColorInt $sut, ColorHSL $expectedOutput): void
    {
        $output = $sut->toHSL();

        static::assertInstanceOf(ColorHSL::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorInt|\Coloreeze\ColorHSL>>
     */
    public static function dataProviderForToHSL(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/Int.php';

        return $sources['toHSL'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToXYZ')]
    public function testToXYZ(ColorInt $sut, ColorXYZ $expectedOutput): void
    {
        $output = $sut->toXYZ();

        static::assertInstanceOf(ColorXYZ::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorInt|\Coloreeze\ColorXYZ>>
     */
    public static function dataProviderForToXYZ(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/Int.php';

        return $sources['toXYZ'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToHSB')]
    public function testToHSB(ColorInt $sut, ColorHSB $expectedOutput): void
    {
        $output = $sut->toHSB();

        static::assertInstanceOf(ColorHSB::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorInt|\Coloreeze\ColorHSB>>
     */
    public static function dataProviderForToHSB(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/Int.php';

        return $sources['toHSB'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToCIELab')]
    public function testToCIELab(ColorInt $sut, ColorCIELab $expectedOutput): void
    {
        $output = $sut->toCIELab();

        static::assertInstanceOf(ColorCIELab::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorInt|\Coloreeze\ColorCIELab>>
     */
    public static function dataProviderForToCIELab(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/Int.php';

        return $sources['toCIELab'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToGreyscale')]
    public function testToGreyscale(ColorInt $sut, ColorInt $expectedOutput): void
    {
        $output = $sut->toGreyscale();

        static::assertInstanceOf(ColorInt::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorInt>>
     */
    public static function dataProviderForToGreyscale(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/Int.php';

        return $sources['toGreyscale'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToComplementary')]
    public function testToComplementary(ColorInt $sut, ColorInt $expectedOutput): void
    {
        $output = $sut->toComplementary();

        static::assertInstanceOf(ColorInt::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorInt>>
     */
    public static function dataProviderForToComplementary(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/Int.php';

        return $sources['toComplementary'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToDarker')]
    public function testToDarker(ColorInt $sut, ColorInt $expectedOutput): void
    {
        $output = $sut->adjustBrightness(-25);

        static::assertInstanceOf(ColorInt::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorInt>>
     */
    public static function dataProviderForToDarker(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/Int.php';

        return $sources['toDarker'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToLighter')]
    public function testToLighter(ColorInt $sut, ColorInt $expectedOutput): void
    {
        $output = $sut->adjustBrightness(25);

        static::assertInstanceOf(ColorInt::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorInt>>
     */
    public static function dataProviderForToLighter(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/Int.php';

        return $sources['toLighter'];
    }
}
