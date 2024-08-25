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
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorCMYK::__construct
     * @covers \Coloreeze\Exceptions\InvalidInput::notInRange
     * @covers \Coloreeze\Color::isInRange
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
     * @covers \Coloreeze\ColorCMYK::__construct
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\ColorCMYK::getValue
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
     * @covers \Coloreeze\ColorCMYK::__construct
     * @covers \Coloreeze\ColorCMYK::fromString
     * @covers \Coloreeze\ColorCMYK::getValue
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\Color::validateFormat
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
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorCMYK::__construct
     * @covers \Coloreeze\ColorCMYK::__toString
     * @covers \Coloreeze\ColorCMYK::distanceCIE76
     * @covers \Coloreeze\ColorCIELab::__construct
     * @covers \Coloreeze\ColorCIELab::__toString
     * @covers \Coloreeze\ColorCIELab::distanceCIE76
     * @covers \Coloreeze\ColorCMYK::toCIELab
     * @covers \Coloreeze\ColorCMYK::toRGBA
     * @covers \Coloreeze\ColorCMYK::toXYZ
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::toXYZ
     * @covers \Coloreeze\ColorXYZ::__construct
     * @covers \Coloreeze\ColorXYZ::toCIELab
     *
     * @dataProvider dataProviderForDistanceCIE76
     */
    public function testDistanceCIE76(ColorCMYK $input1, ColorCMYK $input2, float $expectedValue): void
    {
        $sut = $input1->distanceCIE76($input2);

        static::assertSame($expectedValue, $sut);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorCMYK|float>>
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
     * @covers \Coloreeze\ColorCMYK::__construct
     * @covers \Coloreeze\ColorCMYK::__toString
     *
     * @dataProvider dataProviderForToString
     */
    public function testToString(ColorCMYK $sut, string $expectedOutput): void
    {
        $output = (string) $sut;

        static::assertSame($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorCMYK|string>>
     */
    public function dataProviderForToString(): array
    {
        $sources = include __DIR__ . '/DataSources/CMYK.php';

        return $sources['toString'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\ColorCMYK::__construct
     * @covers \Coloreeze\ColorCMYK::toHex
     * @covers \Coloreeze\ColorCMYK::toRGBA
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\ColorRGBA::toHex
     * @covers \Coloreeze\Color::validateFormat
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
     * @return array<int, array<int, \Coloreeze\ColorCMYK|\Coloreeze\ColorHex>>
     */
    public function dataProviderForToHex(): array
    {
        $sources = include __DIR__ . '/DataSources/CMYK.php';

        return $sources['toHex'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\ColorCMYK::__construct
     * @covers \Coloreeze\ColorCMYK::toInt
     * @covers \Coloreeze\ColorCMYK::toRGBA
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorHex::toInt
     * @covers \Coloreeze\ColorInt::__construct
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\ColorRGBA::toHex
     * @covers \Coloreeze\ColorRGBA::toInt
     * @covers \Coloreeze\Color::validateFormat
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
     * @return array<int, array<int, \Coloreeze\ColorCMYK|\Coloreeze\ColorInt>>
     */
    public function dataProviderForToInt(): array
    {
        $sources = include __DIR__ . '/DataSources/CMYK.php';

        return $sources['toInt'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\ColorCMYK::__construct
     * @covers \Coloreeze\ColorCMYK::toRGBA
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\Color::isInRange
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
     * @return array<int, array<int, \Coloreeze\ColorCMYK|\Coloreeze\ColorRGBA>>
     */
    public function dataProviderForToRGBA(): array
    {
        $sources = include __DIR__ . '/DataSources/CMYK.php';

        return $sources['toRGBA'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\ColorCMYK::__construct
     * @covers \Coloreeze\ColorCMYK::toCMYK
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
     * @return array<int, array<int, \Coloreeze\ColorCMYK|\Coloreeze\ColorCMYK>>
     */
    public function dataProviderForToCMYK(): array
    {
        $sources = include __DIR__ . '/DataSources/CMYK.php';

        return $sources['toCMYK'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\ColorCMYK::__construct
     * @covers \Coloreeze\ColorCMYK::toHSL
     * @covers \Coloreeze\ColorCMYK::toRGBA
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\ColorRGBA::toHSL
     * @covers \Coloreeze\ColorHSL::__construct
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
     * @return array<int, array<int, \Coloreeze\ColorCMYK|\Coloreeze\ColorHSL>>
     */
    public function dataProviderForToHSL(): array
    {
        $sources = include __DIR__ . '/DataSources/CMYK.php';

        return $sources['toHSL'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\ColorCMYK::__construct
     * @covers \Coloreeze\ColorCMYK::toXYZ
     * @covers \Coloreeze\ColorCMYK::toRGBA
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\ColorRGBA::toXYZ
     * @covers \Coloreeze\ColorXYZ::__construct
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
     * @return array<int, array<int, \Coloreeze\ColorCMYK|\Coloreeze\ColorXYZ>>
     */
    public function dataProviderForToXYZ(): array
    {
        $sources = include __DIR__ . '/DataSources/CMYK.php';

        return $sources['toXYZ'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorCMYK::__construct
     * @covers \Coloreeze\ColorCMYK::toHSB
     * @covers \Coloreeze\ColorCMYK::toRGBA
     * @covers \Coloreeze\ColorHSB::__construct
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::toHSB
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
     * @return array<int, array<int, \Coloreeze\ColorCMYK|\Coloreeze\ColorHSB>>
     */
    public function dataProviderForToHSB(): array
    {
        $sources = include __DIR__ . '/DataSources/CMYK.php';

        return $sources['toHSB'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorCIELab::__construct
     * @covers \Coloreeze\ColorCMYK::__construct
     * @covers \Coloreeze\ColorCMYK::toCIELab
     * @covers \Coloreeze\ColorCMYK::toRGBA
     * @covers \Coloreeze\ColorCMYK::toXYZ
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::toXYZ
     * @covers \Coloreeze\ColorXYZ::__construct
     * @covers \Coloreeze\ColorXYZ::toCIELab
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
     * @return array<int, array<int, \Coloreeze\ColorCMYK|\Coloreeze\ColorCIELab>>
     */
    public function dataProviderForToCIELab(): array
    {
        $sources = include __DIR__ . '/DataSources/CMYK.php';

        return $sources['toCIELab'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorCMYK::__construct
     * @covers \Coloreeze\ColorCMYK::toGreyscale
     * @covers \Coloreeze\ColorCMYK::toRGBA
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorHex::toCMYK
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::toCMYK
     * @covers \Coloreeze\ColorRGBA::toGreyscale
     * @covers \Coloreeze\ColorRGBA::toHex
     * @covers \Coloreeze\Color::validateFormat
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
     * @return array<int, array<int, \Coloreeze\ColorCMYK>>
     */
    public function dataProviderForToGreyscale(): array
    {
        $sources = include __DIR__ . '/DataSources/CMYK.php';

        return $sources['toGreyscale'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorCMYK::__construct
     * @covers \Coloreeze\ColorCMYK::toComplementary
     * @covers \Coloreeze\ColorCMYK::toRGBA
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorHex::toCMYK
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::toCMYK
     * @covers \Coloreeze\ColorRGBA::toComplementary
     * @covers \Coloreeze\ColorRGBA::toHex
     * @covers \Coloreeze\Color::validateFormat
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
     * @return array<int, array<int, \Coloreeze\ColorCMYK>>
     */
    public function dataProviderForToComplementary(): array
    {
        $sources = include __DIR__ . '/DataSources/CMYK.php';

        return $sources['toComplementary'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorCMYK::__construct
     * @covers \Coloreeze\ColorCMYK::adjustBrightness
     * @covers \Coloreeze\ColorCMYK::toRGBA
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorHex::toCMYK
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::adjustBrightness
     * @covers \Coloreeze\ColorRGBA::toCMYK
     * @covers \Coloreeze\ColorRGBA::toHex
     * @covers \Coloreeze\Color::validateFormat
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
     * @return array<int, array<int, \Coloreeze\ColorCMYK>>
     */
    public function dataProviderForToDarker(): array
    {
        $sources = include __DIR__ . '/DataSources/CMYK.php';

        return $sources['toDarker'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorCMYK::__construct
     * @covers \Coloreeze\ColorCMYK::adjustBrightness
     * @covers \Coloreeze\ColorCMYK::toRGBA
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorHex::toCMYK
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::adjustBrightness
     * @covers \Coloreeze\ColorRGBA::toCMYK
     * @covers \Coloreeze\ColorRGBA::toHex
     * @covers \Coloreeze\Color::validateFormat
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
     * @return array<int, array<int, \Coloreeze\ColorCMYK>>
     */
    public function dataProviderForToLighter(): array
    {
        $sources = include __DIR__ . '/DataSources/CMYK.php';

        return $sources['toLighter'];
    }
}
