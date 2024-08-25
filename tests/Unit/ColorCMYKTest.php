<?php

namespace UnitTests;

use Coloreeze\ColorCIELab;
use Coloreeze\ColorCMYK;
use Coloreeze\ColorHSB;
use Coloreeze\ColorHSL;
use Coloreeze\ColorHex;
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
final class ColorCMYKTest extends TestCase
{
    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForValidation')]
    public function testValidation(int $cyan, int $magenta, int $yellow, int $key): void
    {
        static::expectException(InvalidInput::class);

        new ColorCMYK($cyan, $magenta, $yellow, $key);
    }

    /**
     * @return array<int, array<int, int>>
     */
    public static function dataProviderForValidation(): array
    {
        return [
            [ColorCMYK::VALUE_MIN__CYAN - 1, 0, 0, 0],
            [ColorCMYK::VALUE_MAX__CYAN + 1, 0, 0, 0],
            [0, ColorCMYK::VALUE_MIN__MAGENTA - 1, 0, 0],
            [0, ColorCMYK::VALUE_MAX__MAGENTA + 1, 0, 0],
            [0, 0, ColorCMYK::VALUE_MIN__YELLOW - 1, 0],
            [0, 0, ColorCMYK::VALUE_MAX__YELLOW + 1, 0],
            [0, 0, 0, ColorCMYK::VALUE_MIN__KEY - 1],
            [0, 0, 0, ColorCMYK::VALUE_MAX__KEY + 1],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForEntity')]
    public function testEntity(int $cyan, int $magenta, int $yellow, int $key, array $expectedValue): void
    {
        $sut = new ColorCMYK($cyan, $magenta, $yellow, $key);

        static::assertInstanceOf(ColorCMYK::class, $sut);
        static::assertSame($expectedValue, $sut->getValue());
    }

    /**
     * @return array<int, array<int, array<int, float>|int>>
     */
    public static function dataProviderForEntity(): array
    {
        return [
            [0, 0, 0, 0, [0.0000, 0.0000, 0.0000, 0.0000]],
            [1, 0, 0, 0, [1.0000, 0.0000, 0.0000, 0.0000]],
            [0, 1, 0, 0, [0.0000, 1.0000, 0.0000, 0.0000]],
            [0, 0, 1, 0, [0.0000, 0.0000, 1.0000, 0.0000]],
            [0, 0, 0, 1, [0.0000, 0.0000, 0.0000, 1.0000]],
            [1, 1, 0, 0, [1.0000, 1.0000, 0.0000, 0.0000]],
            [0, 1, 1, 0, [0.0000, 1.0000, 1.0000, 0.0000]],
            [0, 0, 1, 1, [0.0000, 0.0000, 1.0000, 1.0000]],
            [1, 0, 0, 1, [1.0000, 0.0000, 0.0000, 1.0000]],
            [0, 1, 1, 0, [0.0000, 1.0000, 1.0000, 0.0000]],
            [1, 1, 1, 0, [1.0000, 1.0000, 1.0000, 0.0000]],
            [0, 1, 1, 1, [0.0000, 1.0000, 1.0000, 1.0000]],
            [1, 1, 1, 1, [1.0000, 1.0000, 1.0000, 1.0000]],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForFromString')]
    public function testFromString(string $inputValue, array $expectedValue): void
    {
        $sut = ColorCMYK::fromString($inputValue);

        static::assertInstanceOf(ColorCMYK::class, $sut);
        static::assertSame($expectedValue, $sut->getValue());
    }

    /**
     * @return array<int, array<int, array<int, float>|string>>
     */
    public static function dataProviderForFromString(): array
    {
        return [
            ['cmyk(0,0,0,0)', [0.0000, 0.0000, 0.0000, 0.0000]],
            ['cmyk(1,1,1,1)', [1.0000, 1.0000, 1.0000, 1.0000]],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForDistanceCIE76')]
    public function testDistanceCIE76(ColorCMYK $input1, ColorCMYK $input2, float $expectedValue): void
    {
        $sut = $input1->distanceCIE76($input2);

        static::assertSame($expectedValue, $sut);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorCMYK|float>>
     */
    public static function dataProviderForDistanceCIE76(): array
    {
        return [
            [new ColorCMYK(0.0000, 0.0000, 0.0000, 1.0000), new ColorCMYK(0.0000, 0.0000, 0.0000, 1.0000), 0],
            [new ColorCMYK(0.0000, 0.0000, 0.0000, 1.0000), new ColorCMYK(0.0000, 0.0100, 0.3900, 0.0000), 108.7067],
            [new ColorCMYK(0.0000, 0.7400, 1.0000, 0.0000), new ColorCMYK(1.0000, 0.7900, 0.0000, 0.2400), 152.6311],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToString')]
    public function testToString(ColorCMYK $sut, string $expectedOutput): void
    {
        $output = (string) $sut;

        static::assertSame($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorCMYK|string>>
     */
    public static function dataProviderForToString(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/CMYK.php';

        return $sources['toString'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToHex')]
    public function testToHex(ColorCMYK $sut, ColorHex $expectedOutput): void
    {
        $output = $sut->toHex();

        static::assertInstanceOf(ColorHex::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorCMYK|\Coloreeze\ColorHex>>
     */
    public static function dataProviderForToHex(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/CMYK.php';

        return $sources['toHex'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToInt')]
    public function testToInt(ColorCMYK $sut, ColorInt $expectedOutput): void
    {
        $output = $sut->toInt();

        static::assertInstanceOf(ColorInt::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorCMYK|\Coloreeze\ColorInt>>
     */
    public static function dataProviderForToInt(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/CMYK.php';

        return $sources['toInt'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToRGBA')]
    public function testToRGBA(ColorCMYK $sut, ColorRGBA $expectedOutput): void
    {
        $output = $sut->toRGBA();

        static::assertInstanceOf(ColorRGBA::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorCMYK|\Coloreeze\ColorRGBA>>
     */
    public static function dataProviderForToRGBA(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/CMYK.php';

        return $sources['toRGBA'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToCMYK')]
    public function testToCMYK(ColorCMYK $sut, ColorCMYK $expectedOutput): void
    {
        $output = $sut->toCMYK();

        static::assertInstanceOf(ColorCMYK::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorCMYK|\Coloreeze\ColorCMYK>>
     */
    public static function dataProviderForToCMYK(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/CMYK.php';

        return $sources['toCMYK'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToHSL')]
    public function testToHSL(ColorCMYK $sut, ColorHSL $expectedOutput): void
    {
        $output = $sut->toHSL();

        static::assertInstanceOf(ColorHSL::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorCMYK|\Coloreeze\ColorHSL>>
     */
    public static function dataProviderForToHSL(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/CMYK.php';

        return $sources['toHSL'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToXYZ')]
    public function testToXYZ(ColorCMYK $sut, ColorXYZ $expectedOutput): void
    {
        $output = $sut->toXYZ();

        static::assertInstanceOf(ColorXYZ::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorCMYK|\Coloreeze\ColorXYZ>>
     */
    public static function dataProviderForToXYZ(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/CMYK.php';

        return $sources['toXYZ'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToHSB')]
    public function testToHSB(ColorCMYK $sut, ColorHSB $expectedOutput): void
    {
        $output = $sut->toHSB();

        static::assertInstanceOf(ColorHSB::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorCMYK|\Coloreeze\ColorHSB>>
     */
    public static function dataProviderForToHSB(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/CMYK.php';

        return $sources['toHSB'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToCIELab')]
    public function testToCIELab(ColorCMYK $sut, ColorCIELab $expectedOutput): void
    {
        $output = $sut->toCIELab();

        static::assertInstanceOf(ColorCIELab::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorCMYK|\Coloreeze\ColorCIELab>>
     */
    public static function dataProviderForToCIELab(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/CMYK.php';

        return $sources['toCIELab'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToGreyscale')]
    public function testToGreyscale(ColorCMYK $sut, ColorCMYK $expectedOutput): void
    {
        $output = $sut->toGreyscale();

        static::assertInstanceOf(ColorCMYK::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorCMYK>>
     */
    public static function dataProviderForToGreyscale(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/CMYK.php';

        return $sources['toGreyscale'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToComplementary')]
    public function testToComplementary(ColorCMYK $sut, ColorCMYK $expectedOutput): void
    {
        $output = $sut->toComplementary();

        static::assertInstanceOf(ColorCMYK::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorCMYK>>
     */
    public static function dataProviderForToComplementary(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/CMYK.php';

        return $sources['toComplementary'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToDarker')]
    public function testToDarker(ColorCMYK $sut, ColorCMYK $expectedOutput): void
    {
        $output = $sut->adjustBrightness(-25);

        static::assertInstanceOf(ColorCMYK::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorCMYK>>
     */
    public static function dataProviderForToDarker(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/CMYK.php';

        return $sources['toDarker'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    #[Test]
    #[DataProvider('dataProviderForToLighter')]
    public function testToLighter(ColorCMYK $sut, ColorCMYK $expectedOutput): void
    {
        $output = $sut->adjustBrightness(25);

        static::assertInstanceOf(ColorCMYK::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorCMYK>>
     */
    public static function dataProviderForToLighter(): array
    {
        $sources = include dirname(__DIR__, 1) . '/DataSources/CMYK.php';

        return $sources['toLighter'];
    }
}
