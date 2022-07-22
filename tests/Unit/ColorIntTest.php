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
final class ColorIntTest extends TestCase
{
    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorInt::__construct
     * @covers \Fonil\Coloreeze\Exceptions\InvalidInput::notInRange
     * @covers \Fonil\Coloreeze\Color::isInRange
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
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorInt::__construct
     * @covers \Fonil\Coloreeze\ColorInt::getValue
     * @covers \Fonil\Coloreeze\Color::isInRange
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
     * @covers \Fonil\Coloreeze\ColorInt::__construct
     * @covers \Fonil\Coloreeze\ColorInt::fromString
     * @covers \Fonil\Coloreeze\ColorInt::getValue
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\Color::validateFormat
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
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorCIELab::__construct
     * @covers \Fonil\Coloreeze\ColorCIELab::__toString
     * @covers \Fonil\Coloreeze\ColorCIELab::distanceCIE76
     * @covers \Fonil\Coloreeze\ColorHex::__construct
     * @covers \Fonil\Coloreeze\ColorHex::toRGBA
     * @covers \Fonil\Coloreeze\ColorInt::distanceCIE76
     * @covers \Fonil\Coloreeze\ColorInt::toCIELab
     * @covers \Fonil\Coloreeze\ColorInt::toHex
     * @covers \Fonil\Coloreeze\ColorInt::toRGBA
     * @covers \Fonil\Coloreeze\ColorInt::toXYZ
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::toXYZ
     * @covers \Fonil\Coloreeze\ColorXYZ::__construct
     * @covers \Fonil\Coloreeze\ColorXYZ::toCIELab
     * @covers \Fonil\Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForDistanceCIE76
     */
    public function testDistanceCIE76(ColorInt $input1, ColorInt $input2, float $expectedValue): void
    {
        $sut = $input1->distanceCIE76($input2);

        static::assertSame($expectedValue, $sut);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorInt|float>>
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
     * @covers \Fonil\Coloreeze\ColorInt::__construct
     * @covers \Fonil\Coloreeze\ColorInt::__toString
     *
     * @dataProvider dataProviderForToString
     */
    public function testToString(ColorInt $sut, string $expectedOutput): void
    {
        $output = (string) $sut;

        static::assertSame($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorInt|string>>
     */
    public function dataProviderForToString(): array
    {
        $sources = include __DIR__ . '/DataSources/Int.php';

        return $sources['toString'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\ColorHex::__construct
     * @covers \Fonil\Coloreeze\ColorInt::__construct
     * @covers \Fonil\Coloreeze\ColorInt::toHex
     * @covers \Fonil\Coloreeze\Color::validateFormat
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
     * @return array<int, array<int, \Fonil\Coloreeze\ColorInt|\Fonil\Coloreeze\ColorHex>>
     */
    public function dataProviderForToHex(): array
    {
        $sources = include __DIR__ . '/DataSources/Int.php';

        return $sources['toHex'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\ColorInt::__construct
     * @covers \Fonil\Coloreeze\ColorInt::toInt
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
     * @return array<int, array<int, \Fonil\Coloreeze\ColorInt|\Fonil\Coloreeze\ColorInt>>
     */
    public function dataProviderForToInt(): array
    {
        $sources = include __DIR__ . '/DataSources/Int.php';

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
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateFormat
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
     * @return array<int, array<int, \Fonil\Coloreeze\ColorInt|\Fonil\Coloreeze\ColorRGBA>>
     */
    public function dataProviderForToRGBA(): array
    {
        $sources = include __DIR__ . '/DataSources/Int.php';

        return $sources['toRGBA'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorCMYK::__construct
     * @covers \Fonil\Coloreeze\ColorHex::__construct
     * @covers \Fonil\Coloreeze\ColorHex::toCMYK
     * @covers \Fonil\Coloreeze\ColorInt::__construct
     * @covers \Fonil\Coloreeze\ColorInt::toCMYK
     * @covers \Fonil\Coloreeze\ColorInt::toHex
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateFormat
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
     * @return array<int, array<int, \Fonil\Coloreeze\ColorInt|\Fonil\Coloreeze\ColorCMYK>>
     */
    public function dataProviderForToCMYK(): array
    {
        $sources = include __DIR__ . '/DataSources/Int.php';

        return $sources['toCMYK'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorHex::__construct
     * @covers \Fonil\Coloreeze\ColorHex::toRGBA
     * @covers \Fonil\Coloreeze\ColorHSL::__construct
     * @covers \Fonil\Coloreeze\ColorInt::__construct
     * @covers \Fonil\Coloreeze\ColorInt::toHex
     * @covers \Fonil\Coloreeze\ColorInt::toHSL
     * @covers \Fonil\Coloreeze\ColorInt::toRGBA
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::toHSL
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateFormat
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
     * @return array<int, array<int, \Fonil\Coloreeze\ColorInt|\Fonil\Coloreeze\ColorHSL>>
     */
    public function dataProviderForToHSL(): array
    {
        $sources = include __DIR__ . '/DataSources/Int.php';

        return $sources['toHSL'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorHex::__construct
     * @covers \Fonil\Coloreeze\ColorHex::toRGBA
     * @covers \Fonil\Coloreeze\ColorInt::__construct
     * @covers \Fonil\Coloreeze\ColorInt::toHex
     * @covers \Fonil\Coloreeze\ColorInt::toRGBA
     * @covers \Fonil\Coloreeze\ColorInt::toXYZ
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::toXYZ
     * @covers \Fonil\Coloreeze\ColorXYZ::__construct
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateFormat
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
     * @return array<int, array<int, \Fonil\Coloreeze\ColorInt|\Fonil\Coloreeze\ColorXYZ>>
     */
    public function dataProviderForToXYZ(): array
    {
        $sources = include __DIR__ . '/DataSources/Int.php';

        return $sources['toXYZ'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorHex::__construct
     * @covers \Fonil\Coloreeze\ColorHex::toRGBA
     * @covers \Fonil\Coloreeze\ColorHSB::__construct
     * @covers \Fonil\Coloreeze\ColorInt::__construct
     * @covers \Fonil\Coloreeze\ColorInt::toHex
     * @covers \Fonil\Coloreeze\ColorInt::toHSB
     * @covers \Fonil\Coloreeze\ColorInt::toRGBA
     * @covers \Fonil\Coloreeze\ColorInt::toXYZ
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::toHSB
     * @covers \Fonil\Coloreeze\Color::validateFormat
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
     * @return array<int, array<int, \Fonil\Coloreeze\ColorInt|\Fonil\Coloreeze\ColorHSB>>
     */
    public function dataProviderForToHSB(): array
    {
        $sources = include __DIR__ . '/DataSources/Int.php';

        return $sources['toHSB'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorCIELab::__construct
     * @covers \Fonil\Coloreeze\ColorHex::__construct
     * @covers \Fonil\Coloreeze\ColorHex::toRGBA
     * @covers \Fonil\Coloreeze\ColorInt::toCIELab
     * @covers \Fonil\Coloreeze\ColorInt::toHex
     * @covers \Fonil\Coloreeze\ColorInt::toRGBA
     * @covers \Fonil\Coloreeze\ColorInt::toXYZ
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::toXYZ
     * @covers \Fonil\Coloreeze\ColorXYZ::__construct
     * @covers \Fonil\Coloreeze\ColorXYZ::toCIELab
     * @covers \Fonil\Coloreeze\Color::validateFormat
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
     * @return array<int, array<int, \Fonil\Coloreeze\ColorInt|\Fonil\Coloreeze\ColorCIELab>>
     */
    public function dataProviderForToCIELab(): array
    {
        $sources = include __DIR__ . '/DataSources/Int.php';

        return $sources['toCIELab'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorHex::__construct
     * @covers \Fonil\Coloreeze\ColorHex::toInt
     * @covers \Fonil\Coloreeze\ColorHex::toRGBA
     * @covers \Fonil\Coloreeze\ColorInt::__construct
     * @covers \Fonil\Coloreeze\ColorInt::toGreyscale
     * @covers \Fonil\Coloreeze\ColorInt::toHex
     * @covers \Fonil\Coloreeze\ColorInt::toRGBA
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::toGreyscale
     * @covers \Fonil\Coloreeze\ColorRGBA::toHex
     * @covers \Fonil\Coloreeze\ColorRGBA::toInt
     * @covers \Fonil\Coloreeze\Color::validateFormat
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
     * @return array<int, array<int, \Fonil\Coloreeze\ColorInt>>
     */
    public function dataProviderForToGreyscale(): array
    {
        $sources = include __DIR__ . '/DataSources/Int.php';

        return $sources['toGreyscale'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorHex::__construct
     * @covers \Fonil\Coloreeze\ColorHex::toInt
     * @covers \Fonil\Coloreeze\ColorHex::toRGBA
     * @covers \Fonil\Coloreeze\ColorInt::__construct
     * @covers \Fonil\Coloreeze\ColorInt::toComplementary
     * @covers \Fonil\Coloreeze\ColorInt::toHex
     * @covers \Fonil\Coloreeze\ColorInt::toRGBA
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::toComplementary
     * @covers \Fonil\Coloreeze\ColorRGBA::toHex
     * @covers \Fonil\Coloreeze\ColorRGBA::toInt
     * @covers \Fonil\Coloreeze\Color::validateFormat
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
     * @return array<int, array<int, \Fonil\Coloreeze\ColorInt>>
     */
    public function dataProviderForToComplementary(): array
    {
        $sources = include __DIR__ . '/DataSources/Int.php';

        return $sources['toComplementary'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorHex::__construct
     * @covers \Fonil\Coloreeze\ColorHex::toInt
     * @covers \Fonil\Coloreeze\ColorHex::toRGBA
     * @covers \Fonil\Coloreeze\ColorInt::__construct
     * @covers \Fonil\Coloreeze\ColorInt::adjustBrightness
     * @covers \Fonil\Coloreeze\ColorInt::toHex
     * @covers \Fonil\Coloreeze\ColorInt::toRGBA
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::adjustBrightness
     * @covers \Fonil\Coloreeze\ColorRGBA::toHex
     * @covers \Fonil\Coloreeze\ColorRGBA::toInt
     * @covers \Fonil\Coloreeze\Color::validateFormat
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
     * @return array<int, array<int, \Fonil\Coloreeze\ColorInt>>
     */
    public function dataProviderForToDarker(): array
    {
        $sources = include __DIR__ . '/DataSources/Int.php';

        return $sources['toDarker'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorHex::__construct
     * @covers \Fonil\Coloreeze\ColorHex::toInt
     * @covers \Fonil\Coloreeze\ColorHex::toRGBA
     * @covers \Fonil\Coloreeze\ColorInt::__construct
     * @covers \Fonil\Coloreeze\ColorInt::adjustBrightness
     * @covers \Fonil\Coloreeze\ColorInt::toHex
     * @covers \Fonil\Coloreeze\ColorInt::toRGBA
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::adjustBrightness
     * @covers \Fonil\Coloreeze\ColorRGBA::toHex
     * @covers \Fonil\Coloreeze\ColorRGBA::toInt
     * @covers \Fonil\Coloreeze\Color::validateFormat
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
     * @return array<int, array<int, \Fonil\Coloreeze\ColorInt>>
     */
    public function dataProviderForToLighter(): array
    {
        $sources = include __DIR__ . '/DataSources/Int.php';

        return $sources['toLighter'];
    }
}
