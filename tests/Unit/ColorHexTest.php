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
final class ColorHexTest extends TestCase
{
    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\Color::validateFormat
     * @covers \Coloreeze\Exceptions\InvalidInput::wrongFormat
     *
     * @dataProvider dataProviderForValidation
     */
    public function testValidation(string $inputValue): void
    {
        static::expectException(InvalidInput::class);

        new ColorHex($inputValue);
    }

    /**
     * @return array<int, array<int, string>>
     */
    public function dataProviderForValidation(): array
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

    /**
     * @covers \Coloreeze\Color::validateFormat
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorHex::getValue
     *
     * @dataProvider dataProviderForEntity
     */
    public function testEntity(string $inputValue, string $expectedValue): void
    {
        $sut = new ColorHex($inputValue);

        static::assertInstanceOf(ColorHex::class, $sut);
        static::assertSame($expectedValue, $sut->getValue());
    }

    /**
     * @return array<int, array<int, string|null>>
     */
    public function dataProviderForEntity(): array
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

    /**
     * @covers \Coloreeze\Color::validateFormat
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorHex::fromString
     * @covers \Coloreeze\ColorHex::getValue
     *
     * @dataProvider dataProviderForFromString
     */
    public function testFromString(string $inputValue, string $expectedValue): void
    {
        $sut = ColorHex::fromString($inputValue);

        static::assertInstanceOf(ColorHex::class, $sut);
        static::assertSame($expectedValue, $sut->getValue());
    }

    /**
     * @return array<int, array<int, string|null>>
     */
    public function dataProviderForFromString(): array
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

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorCIELab::__construct
     * @covers \Coloreeze\ColorCIELab::__toString
     * @covers \Coloreeze\ColorCIELab::distanceCIE76
     * @covers \Coloreeze\ColorHex::distanceCIE76
     * @covers \Coloreeze\ColorHex::toCIELab
     * @covers \Coloreeze\ColorHex::toRGBA
     * @covers \Coloreeze\ColorHex::toXYZ
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::toXYZ
     * @covers \Coloreeze\ColorXYZ::__construct
     * @covers \Coloreeze\ColorXYZ::toCIELab
     *
     * @dataProvider dataProviderForDistanceCIE76
     */
    public function testDistanceCIE76(ColorHex $input1, ColorHex $input2, float $expectedValue): void
    {
        $sut = $input1->distanceCIE76($input2);

        static::assertSame($expectedValue, $sut);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHex|float>>
     */
    public function dataProviderForDistanceCIE76(): array
    {
        return [
            [new ColorHex('#000000'), new ColorHex('#000000'), 0],
            [new ColorHex('#000000'), new ColorHex('#FFFD9B'), 109.1308],
            [new ColorHex('#FF3E00'), new ColorHex('#003BC3'), 147.8757],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorHex::__toString
     * @covers \Coloreeze\ColorHex::getValue
     *
     * @dataProvider dataProviderForToString
     */
    public function testToString(ColorHex $sut, string $expectedOutput): void
    {
        $output = (string) $sut;

        static::assertSame($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHex|string>>
     */
    public function dataProviderForToString(): array
    {
        $sources = include __DIR__ . '/DataSources/Hex.php';

        return $sources['toString'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorHex::toHex
     *
     * @dataProvider dataProviderForToHex
     */
    public function testToHex(ColorHex $sut, ColorHex $expectedOutput): void
    {
        $output = $sut->toHex();

        static::assertInstanceOf(ColorHex::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHex>>
     */
    public function dataProviderForToHex(): array
    {
        $sources = include __DIR__ . '/DataSources/Hex.php';

        return $sources['toHex'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorHex::toInt
     * @covers \Coloreeze\ColorInt::__construct
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\Color::isInRange
     *
     * @dataProvider dataProviderForToInt
     */
    public function testToInt(ColorHex $sut, ColorInt $expectedOutput): void
    {
        $output = $sut->toInt();

        static::assertInstanceOf(ColorInt::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHex|\Coloreeze\ColorInt>>
     */
    public function dataProviderForToInt(): array
    {
        $sources = include __DIR__ . '/DataSources/Hex.php';

        return $sources['toInt'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorHex::toRGBA
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\Color::isInRange
     *
     * @dataProvider dataProviderForToRGBA
     */
    public function testToRGBA(ColorHex $sut, ColorRGBA $expectedOutput): void
    {
        $output = $sut->toRGBA();

        static::assertInstanceOf(ColorRGBA::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHex|\Coloreeze\ColorRGBA>>
     */
    public function dataProviderForToRGBA(): array
    {
        $sources = include __DIR__ . '/DataSources/Hex.php';

        return $sources['toRGBA'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorCMYK::__construct
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorHex::toCMYK
     * @covers \Coloreeze\Color::isInRange
     *
     * @dataProvider dataProviderForToCMYK
     */
    public function testToCMYK(ColorHex $sut, ColorCMYK $expectedOutput): void
    {
        $output = $sut->toCMYK();

        static::assertInstanceOf(ColorCMYK::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHex|\Coloreeze\ColorCMYK>>
     */
    public function dataProviderForToCMYK(): array
    {
        $sources = include __DIR__ . '/DataSources/Hex.php';

        return $sources['toCMYK'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorHex::toHSL
     * @covers \Coloreeze\ColorHex::toRGBA
     * @covers \Coloreeze\ColorHSL::__construct
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::toHSL
     * @covers \Coloreeze\Color::isInRange
     *
     * @dataProvider dataProviderForToHSL
     */
    public function testToHSL(ColorHex $sut, ColorHSL $expectedOutput): void
    {
        $output = $sut->toHSL();

        static::assertInstanceOf(ColorHSL::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHex|\Coloreeze\ColorHSL>>
     */
    public function dataProviderForToHSL(): array
    {
        $sources = include __DIR__ . '/DataSources/Hex.php';

        return $sources['toHSL'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorHex::toXYZ
     * @covers \Coloreeze\ColorHex::toRGBA
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::toXYZ
     * @covers \Coloreeze\ColorXYZ::__construct
     * @covers \Coloreeze\Color::isInRange
     *
     * @dataProvider dataProviderForToXYZ
     */
    public function testToXYZ(ColorHex $sut, ColorXYZ $expectedOutput): void
    {
        $output = $sut->toXYZ();

        static::assertInstanceOf(ColorXYZ::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHex|\Coloreeze\ColorXYZ>>
     */
    public function dataProviderForToXYZ(): array
    {
        $sources = include __DIR__ . '/DataSources/Hex.php';

        return $sources['toXYZ'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorHex::toHSB
     * @covers \Coloreeze\ColorHex::toRGBA
     * @covers \Coloreeze\ColorHSB::__construct
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::toHSB
     *
     * @dataProvider dataProviderForToHSB
     */
    public function testToHSB(ColorHex $sut, ColorHSB $expectedOutput): void
    {
        $output = $sut->toHSB();

        static::assertInstanceOf(ColorHSB::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHex|\Coloreeze\ColorHSB>>
     */
    public function dataProviderForToHSB(): array
    {
        $sources = include __DIR__ . '/DataSources/Hex.php';

        return $sources['toHSB'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorCIELab::__construct
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorHex::toCIELab
     * @covers \Coloreeze\ColorHex::toRGBA
     * @covers \Coloreeze\ColorHex::toXYZ
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::toXYZ
     * @covers \Coloreeze\ColorXYZ::__construct
     * @covers \Coloreeze\ColorXYZ::toCIELab
     *
     * @dataProvider dataProviderForToCIELab
     */
    public function testToCIELab(ColorHex $sut, ColorCIELab $expectedOutput): void
    {
        $output = $sut->toCIELab();

        static::assertInstanceOf(ColorCIELab::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHex|\Coloreeze\ColorCIELab>>
     */
    public function dataProviderForToCIELab(): array
    {
        $sources = include __DIR__ . '/DataSources/Hex.php';

        return $sources['toCIELab'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorHex::toGreyscale
     * @covers \Coloreeze\ColorHex::toRGBA
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::toGreyscale
     * @covers \Coloreeze\ColorRGBA::toHex
     * @covers \Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForToGreyscale
     */
    public function testToGreyscale(ColorHex $sut, ColorHex $expectedOutput): void
    {
        $output = $sut->toGreyscale();

        static::assertInstanceOf(ColorHex::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHex>>
     */
    public function dataProviderForToGreyscale(): array
    {
        $sources = include __DIR__ . '/DataSources/Hex.php';

        return $sources['toGreyscale'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorHex::toComplementary
     * @covers \Coloreeze\ColorHex::toRGBA
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::toComplementary
     * @covers \Coloreeze\ColorRGBA::toHex
     * @covers \Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForToComplementary
     */
    public function testToComplementary(ColorHex $sut, ColorHex $expectedOutput): void
    {
        $output = $sut->toComplementary();

        static::assertInstanceOf(ColorHex::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHex>>
     */
    public function dataProviderForToComplementary(): array
    {
        $sources = include __DIR__ . '/DataSources/Hex.php';

        return $sources['toComplementary'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorHex::adjustBrightness
     * @covers \Coloreeze\ColorHex::toRGBA
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::adjustBrightness
     * @covers \Coloreeze\ColorRGBA::toHex
     * @covers \Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForToDarker
     */
    public function testToDarker(ColorHex $sut, ColorHex $expectedOutput): void
    {
        $output = $sut->adjustBrightness(-25);

        static::assertInstanceOf(ColorHex::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHex>>
     */
    public function dataProviderForToDarker(): array
    {
        $sources = include __DIR__ . '/DataSources/Hex.php';

        return $sources['toDarker'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorHex::adjustBrightness
     * @covers \Coloreeze\ColorHex::toRGBA
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::adjustBrightness
     * @covers \Coloreeze\ColorRGBA::toHex
     * @covers \Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForToLighter
     */
    public function testToLighter(ColorHex $sut, ColorHex $expectedOutput): void
    {
        $output = $sut->adjustBrightness(25);

        static::assertInstanceOf(ColorHex::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHex>>
     */
    public function dataProviderForToLighter(): array
    {
        $sources = include __DIR__ . '/DataSources/Hex.php';

        return $sources['toLighter'];
    }
}
