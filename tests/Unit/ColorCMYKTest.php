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
final class ColorCMYKTest extends TestCase
{
    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorCMYK::__construct
     * @covers \Fonil\Coloreeze\Exceptions\InvalidInput::notInRange
     * @covers \Fonil\Coloreeze\Color::isInRange
     *
     * @dataProvider dataProviderForValidation
     */
    public function testValidation(int $cyan, int $magenta, int $yellow, int $key): void
    {
        static::expectException(InvalidInput::class);

        new ColorCMYK($cyan, $magenta, $yellow, $key);
    }

    /**
     * @return array<int, array<int, int>>
     */
    public function dataProviderForValidation(): array
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

    /**
     * @param array<int> $expectedValue
     *
     * @covers \Fonil\Coloreeze\ColorCMYK::__construct
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\ColorCMYK::getValue
     *
     * @dataProvider dataProviderForEntity
     */
    public function testEntity(int $cyan, int $magenta, int $yellow, int $key, array $expectedValue): void
    {
        $sut = new ColorCMYK($cyan, $magenta, $yellow, $key);

        static::assertInstanceOf(ColorCMYK::class, $sut);
        static::assertSame($expectedValue, $sut->getValue());
    }

    /**
     * @return array<int, array<int, array<int, float>|int>>
     */
    public function dataProviderForEntity(): array
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

    /**
     * @param array<int, array<int, array<int, float>|string>> $expectedValue
     *
     * @covers \Fonil\Coloreeze\ColorCMYK::__construct
     * @covers \Fonil\Coloreeze\ColorCMYK::fromString
     * @covers \Fonil\Coloreeze\ColorCMYK::getValue
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForFromString
     */
    public function testFromString(string $inputValue, array $expectedValue): void
    {
        $sut = ColorCMYK::fromString($inputValue);

        static::assertInstanceOf(ColorCMYK::class, $sut);
        static::assertSame($expectedValue, $sut->getValue());
    }

    /**
     * @return array<int, array<int, array<int, float>|string>>
     */
    public function dataProviderForFromString(): array
    {
        return [
            ['cmyk(0,0,0,0)', [0.0000, 0.0000, 0.0000, 0.0000]],
            ['cmyk(1,1,1,1)', [1.0000, 1.0000, 1.0000, 1.0000]],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorCMYK::__construct
     * @covers \Fonil\Coloreeze\ColorCMYK::__toString
     * @covers \Fonil\Coloreeze\ColorCMYK::distanceCIE76
     * @covers \Fonil\Coloreeze\ColorCIELab::__construct
     * @covers \Fonil\Coloreeze\ColorCIELab::__toString
     * @covers \Fonil\Coloreeze\ColorCIELab::distanceCIE76
     * @covers \Fonil\Coloreeze\ColorCMYK::toCIELab
     * @covers \Fonil\Coloreeze\ColorCMYK::toRGBA
     * @covers \Fonil\Coloreeze\ColorCMYK::toXYZ
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::toXYZ
     * @covers \Fonil\Coloreeze\ColorXYZ::__construct
     * @covers \Fonil\Coloreeze\ColorXYZ::toCIELab
     *
     * @dataProvider dataProviderForDistanceCIE76
     */
    public function testDistanceCIE76(ColorCMYK $input1, ColorCMYK $input2, float $expectedValue): void
    {
        $sut = $input1->distanceCIE76($input2);

        static::assertSame($expectedValue, $sut);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorCMYK|float>>
     */
    public function dataProviderForDistanceCIE76(): array
    {
        return [
            [new ColorCMYK(0.0000, 0.0000, 0.0000, 1.0000), new ColorCMYK(0.0000, 0.0000, 0.0000, 1.0000), 0],
            [new ColorCMYK(0.0000, 0.0000, 0.0000, 1.0000), new ColorCMYK(0.0000, 0.0100, 0.3900, 0.0000), 108.7067],
            [new ColorCMYK(0.0000, 0.7400, 1.0000, 0.0000), new ColorCMYK(1.0000, 0.7900, 0.0000, 0.2400), 152.6311],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\ColorCMYK::__construct
     * @covers \Fonil\Coloreeze\ColorCMYK::__toString
     *
     * @dataProvider dataProviderForToString
     */
    public function testToString(ColorCMYK $sut, string $expectedOutput): void
    {
        $output = (string) $sut;

        static::assertSame($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorCMYK|string>>
     */
    public function dataProviderForToString(): array
    {
        $sources = include __DIR__ . '/DataSources/CMYK.php';

        return $sources['toString'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\ColorCMYK::__construct
     * @covers \Fonil\Coloreeze\ColorCMYK::toHex
     * @covers \Fonil\Coloreeze\ColorCMYK::toRGBA
     * @covers \Fonil\Coloreeze\ColorHex::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\ColorRGBA::toHex
     * @covers \Fonil\Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForToHex
     */
    public function testToHex(ColorCMYK $sut, ColorHex $expectedOutput): void
    {
        $output = $sut->toHex();

        static::assertInstanceOf(ColorHex::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorCMYK|\Fonil\Coloreeze\ColorHex>>
     */
    public function dataProviderForToHex(): array
    {
        $sources = include __DIR__ . '/DataSources/CMYK.php';

        return $sources['toHex'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\ColorCMYK::__construct
     * @covers \Fonil\Coloreeze\ColorCMYK::toInt
     * @covers \Fonil\Coloreeze\ColorCMYK::toRGBA
     * @covers \Fonil\Coloreeze\ColorHex::__construct
     * @covers \Fonil\Coloreeze\ColorHex::toInt
     * @covers \Fonil\Coloreeze\ColorInt::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\ColorRGBA::toHex
     * @covers \Fonil\Coloreeze\ColorRGBA::toInt
     * @covers \Fonil\Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForToInt
     */
    public function testToInt(ColorCMYK $sut, ColorInt $expectedOutput): void
    {
        $output = $sut->toInt();

        static::assertInstanceOf(ColorInt::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorCMYK|\Fonil\Coloreeze\ColorInt>>
     */
    public function dataProviderForToInt(): array
    {
        $sources = include __DIR__ . '/DataSources/CMYK.php';

        return $sources['toInt'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\ColorCMYK::__construct
     * @covers \Fonil\Coloreeze\ColorCMYK::toRGBA
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\Color::isInRange
     *
     * @dataProvider dataProviderForToRGBA
     */
    public function testToRGBA(ColorCMYK $sut, ColorRGBA $expectedOutput): void
    {
        $output = $sut->toRGBA();

        static::assertInstanceOf(ColorRGBA::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorCMYK|\Fonil\Coloreeze\ColorRGBA>>
     */
    public function dataProviderForToRGBA(): array
    {
        $sources = include __DIR__ . '/DataSources/CMYK.php';

        return $sources['toRGBA'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\ColorCMYK::__construct
     * @covers \Fonil\Coloreeze\ColorCMYK::toCMYK
     *
     * @dataProvider dataProviderForToCMYK
     */
    public function testToCMYK(ColorCMYK $sut, ColorCMYK $expectedOutput): void
    {
        $output = $sut->toCMYK();

        static::assertInstanceOf(ColorCMYK::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorCMYK|\Fonil\Coloreeze\ColorCMYK>>
     */
    public function dataProviderForToCMYK(): array
    {
        $sources = include __DIR__ . '/DataSources/CMYK.php';

        return $sources['toCMYK'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\ColorCMYK::__construct
     * @covers \Fonil\Coloreeze\ColorCMYK::toHSL
     * @covers \Fonil\Coloreeze\ColorCMYK::toRGBA
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\ColorRGBA::toHSL
     * @covers \Fonil\Coloreeze\ColorHSL::__construct
     *
     * @dataProvider dataProviderForToHSL
     */
    public function testToHSL(ColorCMYK $sut, ColorHSL $expectedOutput): void
    {
        $output = $sut->toHSL();

        static::assertInstanceOf(ColorHSL::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorCMYK|\Fonil\Coloreeze\ColorHSL>>
     */
    public function dataProviderForToHSL(): array
    {
        $sources = include __DIR__ . '/DataSources/CMYK.php';

        return $sources['toHSL'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\ColorCMYK::__construct
     * @covers \Fonil\Coloreeze\ColorCMYK::toXYZ
     * @covers \Fonil\Coloreeze\ColorCMYK::toRGBA
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\ColorRGBA::toXYZ
     * @covers \Fonil\Coloreeze\ColorXYZ::__construct
     *
     * @dataProvider dataProviderForToXYZ
     */
    public function testToXYZ(ColorCMYK $sut, ColorXYZ $expectedOutput): void
    {
        $output = $sut->toXYZ();

        static::assertInstanceOf(ColorXYZ::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorCMYK|\Fonil\Coloreeze\ColorXYZ>>
     */
    public function dataProviderForToXYZ(): array
    {
        $sources = include __DIR__ . '/DataSources/CMYK.php';

        return $sources['toXYZ'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorCMYK::__construct
     * @covers \Fonil\Coloreeze\ColorCMYK::toHSB
     * @covers \Fonil\Coloreeze\ColorCMYK::toRGBA
     * @covers \Fonil\Coloreeze\ColorHSB::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::toHSB
     *
     * @dataProvider dataProviderForToHSB
     */
    public function testToHSB(ColorCMYK $sut, ColorHSB $expectedOutput): void
    {
        $output = $sut->toHSB();

        static::assertInstanceOf(ColorHSB::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorCMYK|\Fonil\Coloreeze\ColorHSB>>
     */
    public function dataProviderForToHSB(): array
    {
        $sources = include __DIR__ . '/DataSources/CMYK.php';

        return $sources['toHSB'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorCIELab::__construct
     * @covers \Fonil\Coloreeze\ColorCMYK::__construct
     * @covers \Fonil\Coloreeze\ColorCMYK::toCIELab
     * @covers \Fonil\Coloreeze\ColorCMYK::toRGBA
     * @covers \Fonil\Coloreeze\ColorCMYK::toXYZ
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::toXYZ
     * @covers \Fonil\Coloreeze\ColorXYZ::__construct
     * @covers \Fonil\Coloreeze\ColorXYZ::toCIELab
     *
     * @dataProvider dataProviderForToCIELab
     */
    public function testToCIELab(ColorCMYK $sut, ColorCIELab $expectedOutput): void
    {
        $output = $sut->toCIELab();

        static::assertInstanceOf(ColorCIELab::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorCMYK|\Fonil\Coloreeze\ColorCIELab>>
     */
    public function dataProviderForToCIELab(): array
    {
        $sources = include __DIR__ . '/DataSources/CMYK.php';

        return $sources['toCIELab'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorCMYK::__construct
     * @covers \Fonil\Coloreeze\ColorCMYK::toGreyscale
     * @covers \Fonil\Coloreeze\ColorCMYK::toRGBA
     * @covers \Fonil\Coloreeze\ColorHex::__construct
     * @covers \Fonil\Coloreeze\ColorHex::toCMYK
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::toCMYK
     * @covers \Fonil\Coloreeze\ColorRGBA::toGreyscale
     * @covers \Fonil\Coloreeze\ColorRGBA::toHex
     * @covers \Fonil\Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForToGreyscale
     */
    public function testToGreyscale(ColorCMYK $sut, ColorCMYK $expectedOutput): void
    {
        $output = $sut->toGreyscale();

        static::assertInstanceOf(ColorCMYK::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorCMYK>>
     */
    public function dataProviderForToGreyscale(): array
    {
        $sources = include __DIR__ . '/DataSources/CMYK.php';

        return $sources['toGreyscale'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorCMYK::__construct
     * @covers \Fonil\Coloreeze\ColorCMYK::toComplementary
     * @covers \Fonil\Coloreeze\ColorCMYK::toRGBA
     * @covers \Fonil\Coloreeze\ColorHex::__construct
     * @covers \Fonil\Coloreeze\ColorHex::toCMYK
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::toCMYK
     * @covers \Fonil\Coloreeze\ColorRGBA::toComplementary
     * @covers \Fonil\Coloreeze\ColorRGBA::toHex
     * @covers \Fonil\Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForToComplementary
     */
    public function testToComplementary(ColorCMYK $sut, ColorCMYK $expectedOutput): void
    {
        $output = $sut->toComplementary();

        static::assertInstanceOf(ColorCMYK::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorCMYK>>
     */
    public function dataProviderForToComplementary(): array
    {
        $sources = include __DIR__ . '/DataSources/CMYK.php';

        return $sources['toComplementary'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorCMYK::__construct
     * @covers \Fonil\Coloreeze\ColorCMYK::adjustBrightness
     * @covers \Fonil\Coloreeze\ColorCMYK::toRGBA
     * @covers \Fonil\Coloreeze\ColorHex::__construct
     * @covers \Fonil\Coloreeze\ColorHex::toCMYK
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::adjustBrightness
     * @covers \Fonil\Coloreeze\ColorRGBA::toCMYK
     * @covers \Fonil\Coloreeze\ColorRGBA::toHex
     * @covers \Fonil\Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForToDarker
     */
    public function testToDarker(ColorCMYK $sut, ColorCMYK $expectedOutput): void
    {
        $output = $sut->adjustBrightness(-25);

        static::assertInstanceOf(ColorCMYK::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorCMYK>>
     */
    public function dataProviderForToDarker(): array
    {
        $sources = include __DIR__ . '/DataSources/CMYK.php';

        return $sources['toDarker'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorCMYK::__construct
     * @covers \Fonil\Coloreeze\ColorCMYK::adjustBrightness
     * @covers \Fonil\Coloreeze\ColorCMYK::toRGBA
     * @covers \Fonil\Coloreeze\ColorHex::__construct
     * @covers \Fonil\Coloreeze\ColorHex::toCMYK
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::adjustBrightness
     * @covers \Fonil\Coloreeze\ColorRGBA::toCMYK
     * @covers \Fonil\Coloreeze\ColorRGBA::toHex
     * @covers \Fonil\Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForToLighter
     */
    public function testToLighter(ColorCMYK $sut, ColorCMYK $expectedOutput): void
    {
        $output = $sut->adjustBrightness(25);

        static::assertInstanceOf(ColorCMYK::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorCMYK>>
     */
    public function dataProviderForToLighter(): array
    {
        $sources = include __DIR__ . '/DataSources/CMYK.php';

        return $sources['toLighter'];
    }
}
