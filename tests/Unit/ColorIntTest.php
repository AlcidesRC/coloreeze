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
final class ColorIntTest extends TestCase
{
    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorInt::__construct
     * @covers \Coloreeze\Exceptions\InvalidInput::notInRange
     * @covers \Coloreeze\Color::isInRange
     *
     * @dataProvider dataProviderForValidation
     */
    public function testValidation(int $inputValue): void
    {
        static::expectException(InvalidInput::class);

        new ColorInt($inputValue);
    }

    /**
     * @return array<int, array<int, int>>
     */
    public function dataProviderForValidation(): array
    {
        return [
            [ColorInt::VALUE_MIN - 1],
            [ColorInt::VALUE_MAX + 1],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorInt::__construct
     * @covers \Coloreeze\ColorInt::getValue
     * @covers \Coloreeze\Color::isInRange
     *
     * @dataProvider dataProviderForEntity
     */
    public function testEntity(int $inputValue, int $expectedValue): void
    {
        $sut = new ColorInt($inputValue);

        static::assertInstanceOf(ColorInt::class, $sut);
        static::assertSame($expectedValue, $sut->getValue());
    }

    /**
     * @return array<int, array<int, int>>
     */
    public function dataProviderForEntity(): array
    {
        return [
            [ColorInt::VALUE_MIN, ColorInt::VALUE_MIN],
            [ColorInt::VALUE_MAX, ColorInt::VALUE_MAX],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\ColorInt::__construct
     * @covers \Coloreeze\ColorInt::fromString
     * @covers \Coloreeze\ColorInt::getValue
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForFromString
     */
    public function testFromString(string $inputValue, int $expectedValue): void
    {
        $sut = ColorInt::fromString($inputValue);

        static::assertInstanceOf(ColorInt::class, $sut);
        static::assertSame($expectedValue, $sut->getValue());
    }

    /**
     * @return array<int, array<int, int|string>>
     */
    public function dataProviderForFromString(): array
    {
        return [
            ['int(0)', ColorInt::VALUE_MIN],
            ['int(255)', 255],
            ['int(123456)', 123456],
            ['int(4294967295)', ColorInt::VALUE_MAX],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorCIELab::__construct
     * @covers \Coloreeze\ColorCIELab::__toString
     * @covers \Coloreeze\ColorCIELab::distanceCIE76
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorHex::toRGBA
     * @covers \Coloreeze\ColorInt::distanceCIE76
     * @covers \Coloreeze\ColorInt::toCIELab
     * @covers \Coloreeze\ColorInt::toHex
     * @covers \Coloreeze\ColorInt::toRGBA
     * @covers \Coloreeze\ColorInt::toXYZ
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::toXYZ
     * @covers \Coloreeze\ColorXYZ::__construct
     * @covers \Coloreeze\ColorXYZ::toCIELab
     * @covers \Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForDistanceCIE76
     */
    public function testDistanceCIE76(ColorInt $input1, ColorInt $input2, float $expectedValue): void
    {
        $sut = $input1->distanceCIE76($input2);

        static::assertSame($expectedValue, $sut);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorInt|float>>
     */
    public function dataProviderForDistanceCIE76(): array
    {
        return [
            [new ColorInt(255), new ColorInt(255), 0],
            [new ColorInt(255), new ColorInt(4294810623), 109.1308],
            [new ColorInt(4282253567), new ColorInt(3916799), 147.8757],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\ColorInt::__construct
     * @covers \Coloreeze\ColorInt::__toString
     *
     * @dataProvider dataProviderForToString
     */
    public function testToString(ColorInt $sut, string $expectedOutput): void
    {
        $output = (string) $sut;

        static::assertSame($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorInt|string>>
     */
    public function dataProviderForToString(): array
    {
        $sources = include __DIR__ . '/DataSources/Int.php';

        return $sources['toString'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorInt::__construct
     * @covers \Coloreeze\ColorInt::toHex
     * @covers \Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForToHex
     */
    public function testToHex(ColorInt $sut, ColorHex $expectedOutput): void
    {
        $output = $sut->toHex();

        static::assertInstanceOf(ColorHex::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorInt|\Coloreeze\ColorHex>>
     */
    public function dataProviderForToHex(): array
    {
        $sources = include __DIR__ . '/DataSources/Int.php';

        return $sources['toHex'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\ColorInt::__construct
     * @covers \Coloreeze\ColorInt::toInt
     *
     * @dataProvider dataProviderForToInt
     */
    public function testToInt(ColorInt $sut, ColorInt $expectedOutput): void
    {
        $output = $sut->toInt();

        static::assertInstanceOf(ColorInt::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorInt|\Coloreeze\ColorInt>>
     */
    public function dataProviderForToInt(): array
    {
        $sources = include __DIR__ . '/DataSources/Int.php';

        return $sources['toInt'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorHex::toRGBA
     * @covers \Coloreeze\ColorInt::__construct
     * @covers \Coloreeze\ColorInt::toHex
     * @covers \Coloreeze\ColorInt::toRGBA
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForToRGBA
     */
    public function testToRGBA(ColorInt $sut, ColorRGBA $expectedOutput): void
    {
        $output = $sut->toRGBA();

        static::assertInstanceOf(ColorRGBA::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorInt|\Coloreeze\ColorRGBA>>
     */
    public function dataProviderForToRGBA(): array
    {
        $sources = include __DIR__ . '/DataSources/Int.php';

        return $sources['toRGBA'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorCMYK::__construct
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorHex::toCMYK
     * @covers \Coloreeze\ColorInt::__construct
     * @covers \Coloreeze\ColorInt::toCMYK
     * @covers \Coloreeze\ColorInt::toHex
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForToCMYK
     */
    public function testToCMYK(ColorInt $sut, ColorCMYK $expectedOutput): void
    {
        $output = $sut->toCMYK();

        static::assertInstanceOf(ColorCMYK::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorInt|\Coloreeze\ColorCMYK>>
     */
    public function dataProviderForToCMYK(): array
    {
        $sources = include __DIR__ . '/DataSources/Int.php';

        return $sources['toCMYK'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorHex::toRGBA
     * @covers \Coloreeze\ColorHSL::__construct
     * @covers \Coloreeze\ColorInt::__construct
     * @covers \Coloreeze\ColorInt::toHex
     * @covers \Coloreeze\ColorInt::toHSL
     * @covers \Coloreeze\ColorInt::toRGBA
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::toHSL
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForToHSL
     */
    public function testToHSL(ColorInt $sut, ColorHSL $expectedOutput): void
    {
        $output = $sut->toHSL();

        static::assertInstanceOf(ColorHSL::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorInt|\Coloreeze\ColorHSL>>
     */
    public function dataProviderForToHSL(): array
    {
        $sources = include __DIR__ . '/DataSources/Int.php';

        return $sources['toHSL'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorHex::toRGBA
     * @covers \Coloreeze\ColorInt::__construct
     * @covers \Coloreeze\ColorInt::toHex
     * @covers \Coloreeze\ColorInt::toRGBA
     * @covers \Coloreeze\ColorInt::toXYZ
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::toXYZ
     * @covers \Coloreeze\ColorXYZ::__construct
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForToXYZ
     */
    public function testToXYZ(ColorInt $sut, ColorXYZ $expectedOutput): void
    {
        $output = $sut->toXYZ();

        static::assertInstanceOf(ColorXYZ::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorInt|\Coloreeze\ColorXYZ>>
     */
    public function dataProviderForToXYZ(): array
    {
        $sources = include __DIR__ . '/DataSources/Int.php';

        return $sources['toXYZ'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorHex::toRGBA
     * @covers \Coloreeze\ColorHSB::__construct
     * @covers \Coloreeze\ColorInt::__construct
     * @covers \Coloreeze\ColorInt::toHex
     * @covers \Coloreeze\ColorInt::toHSB
     * @covers \Coloreeze\ColorInt::toRGBA
     * @covers \Coloreeze\ColorInt::toXYZ
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::toHSB
     * @covers \Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForToHSB
     */
    public function testToHSB(ColorInt $sut, ColorHSB $expectedOutput): void
    {
        $output = $sut->toHSB();

        static::assertInstanceOf(ColorHSB::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorInt|\Coloreeze\ColorHSB>>
     */
    public function dataProviderForToHSB(): array
    {
        $sources = include __DIR__ . '/DataSources/Int.php';

        return $sources['toHSB'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorCIELab::__construct
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorHex::toRGBA
     * @covers \Coloreeze\ColorInt::toCIELab
     * @covers \Coloreeze\ColorInt::toHex
     * @covers \Coloreeze\ColorInt::toRGBA
     * @covers \Coloreeze\ColorInt::toXYZ
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::toXYZ
     * @covers \Coloreeze\ColorXYZ::__construct
     * @covers \Coloreeze\ColorXYZ::toCIELab
     * @covers \Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForToCIELab
     */
    public function testToCIELab(ColorInt $sut, ColorCIELab $expectedOutput): void
    {
        $output = $sut->toCIELab();

        static::assertInstanceOf(ColorCIELab::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorInt|\Coloreeze\ColorCIELab>>
     */
    public function dataProviderForToCIELab(): array
    {
        $sources = include __DIR__ . '/DataSources/Int.php';

        return $sources['toCIELab'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorHex::toInt
     * @covers \Coloreeze\ColorHex::toRGBA
     * @covers \Coloreeze\ColorInt::__construct
     * @covers \Coloreeze\ColorInt::toGreyscale
     * @covers \Coloreeze\ColorInt::toHex
     * @covers \Coloreeze\ColorInt::toRGBA
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::toGreyscale
     * @covers \Coloreeze\ColorRGBA::toHex
     * @covers \Coloreeze\ColorRGBA::toInt
     * @covers \Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForToGreyscale
     */
    public function testToGreyscale(ColorInt $sut, ColorInt $expectedOutput): void
    {
        $output = $sut->toGreyscale();

        static::assertInstanceOf(ColorInt::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorInt>>
     */
    public function dataProviderForToGreyscale(): array
    {
        $sources = include __DIR__ . '/DataSources/Int.php';

        return $sources['toGreyscale'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorHex::toInt
     * @covers \Coloreeze\ColorHex::toRGBA
     * @covers \Coloreeze\ColorInt::__construct
     * @covers \Coloreeze\ColorInt::toComplementary
     * @covers \Coloreeze\ColorInt::toHex
     * @covers \Coloreeze\ColorInt::toRGBA
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::toComplementary
     * @covers \Coloreeze\ColorRGBA::toHex
     * @covers \Coloreeze\ColorRGBA::toInt
     * @covers \Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForToComplementary
     */
    public function testToComplementary(ColorInt $sut, ColorInt $expectedOutput): void
    {
        $output = $sut->toComplementary();

        static::assertInstanceOf(ColorInt::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorInt>>
     */
    public function dataProviderForToComplementary(): array
    {
        $sources = include __DIR__ . '/DataSources/Int.php';

        return $sources['toComplementary'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorHex::toInt
     * @covers \Coloreeze\ColorHex::toRGBA
     * @covers \Coloreeze\ColorInt::__construct
     * @covers \Coloreeze\ColorInt::adjustBrightness
     * @covers \Coloreeze\ColorInt::toHex
     * @covers \Coloreeze\ColorInt::toRGBA
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::adjustBrightness
     * @covers \Coloreeze\ColorRGBA::toHex
     * @covers \Coloreeze\ColorRGBA::toInt
     * @covers \Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForToDarker
     */
    public function testToDarker(ColorInt $sut, ColorInt $expectedOutput): void
    {
        $output = $sut->adjustBrightness(-25);

        static::assertInstanceOf(ColorInt::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorInt>>
     */
    public function dataProviderForToDarker(): array
    {
        $sources = include __DIR__ . '/DataSources/Int.php';

        return $sources['toDarker'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorHex::toInt
     * @covers \Coloreeze\ColorHex::toRGBA
     * @covers \Coloreeze\ColorInt::__construct
     * @covers \Coloreeze\ColorInt::adjustBrightness
     * @covers \Coloreeze\ColorInt::toHex
     * @covers \Coloreeze\ColorInt::toRGBA
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::adjustBrightness
     * @covers \Coloreeze\ColorRGBA::toHex
     * @covers \Coloreeze\ColorRGBA::toInt
     * @covers \Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForToLighter
     */
    public function testToLighter(ColorInt $sut, ColorInt $expectedOutput): void
    {
        $output = $sut->adjustBrightness(25);

        static::assertInstanceOf(ColorInt::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorInt>>
     */
    public function dataProviderForToLighter(): array
    {
        $sources = include __DIR__ . '/DataSources/Int.php';

        return $sources['toLighter'];
    }
}
