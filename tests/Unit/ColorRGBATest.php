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
final class ColorRGBATest extends TestCase
{
    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\Exceptions\InvalidInput::notInRange
     * @covers \Coloreeze\Color::isInRange
     *
     * @dataProvider dataProviderForValidation
     */
    public function testValidation(int $red, int $green, int $blue, float $alpha): void
    {
        static::expectException(InvalidInput::class);

        new ColorRGBA($red, $green, $blue, $alpha);
    }

    /**
     * @return array<int, array<int, float|int>>
     */
    public function dataProviderForValidation(): array
    {
        return [
            [ColorRGBA::VALUE_MIN__RED - 1, 0, 0, 0],
            [ColorRGBA::VALUE_MAX__RED + 1, 0, 0, 0],
            [0, ColorRGBA::VALUE_MIN__GREEN - 1, 0, 0],
            [0, ColorRGBA::VALUE_MAX__GREEN + 1, 0, 0],
            [0, 0, ColorRGBA::VALUE_MIN__BLUE - 1, 0],
            [0, 0, ColorRGBA::VALUE_MAX__BLUE + 1, 0],
            [0, 0, 0, ColorRGBA::VALUE_MIN__ALPHA - 1],
            [0, 0, 0, ColorRGBA::VALUE_MAX__ALPHA + 1],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @param array<int|float> $expectedValue
     *
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::getValue
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\Color::isInRange
     *
     * @dataProvider dataProviderForEntity
     */
    public function testEntity(int $red, int $green, int $blue, array $expectedValue): void
    {
        $sut = new ColorRGBA($red, $green, $blue);

        static::assertInstanceOf(ColorRGBA::class, $sut);
        static::assertSame($expectedValue, $sut->getValue());
    }

    /**
     * @return array<int, array<int, array<int, float|int>|int>>
     */
    public function dataProviderForEntity(): array
    {
        return [
            [0, 0, 0, [0, 0, 0, 1.00]],
            [0, 0, 15, [0, 0, 15, 1.00]],
            [0, 0, 255, [0, 0, 255, 1.00]],
            [0, 15, 255, [0, 15, 255, 1.00]],
            [0, 255, 255, [0, 255, 255, 1.00]],
            [15, 255, 255, [15, 255, 255, 1.00]],
            [255, 255, 255, [255, 255, 255, 1.00]],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @param array<int, array<int, array<int, float|int>|string>> $expectedValue
     *
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::fromString
     * @covers \Coloreeze\ColorRGBA::getValue
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForFromString
     */
    public function testFromString(string $inputValue, array $expectedValue): void
    {
        $sut = ColorRGBA::fromString($inputValue);

        static::assertInstanceOf(ColorRGBA::class, $sut);
        static::assertSame($expectedValue, $sut->getValue());
    }

    /**
     * @return array<int, array<int, array<int, float|int>|string>>
     */
    public function dataProviderForFromString(): array
    {
        return [
            ['rgba(0,0,0,0)', [0, 0, 0, 0.00]],
            ['rgba(255,255,255,1)', [255, 255, 255, 1.00]],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorCIELab::__construct
     * @covers \Coloreeze\ColorCIELab::__toString
     * @covers \Coloreeze\ColorCIELab::distanceCIE76
     * @covers \Coloreeze\ColorRGBA::distanceCIE76
     * @covers \Coloreeze\ColorRGBA::toCIELab
     * @covers \Coloreeze\ColorRGBA::toXYZ
     * @covers \Coloreeze\ColorXYZ::__construct
     * @covers \Coloreeze\ColorXYZ::toCIELab
     *
     * @dataProvider dataProviderForDistanceCIE76
     */
    public function testDistanceCIE76(ColorRGBA $input1, ColorRGBA $input2, float $expectedValue): void
    {
        $sut = $input1->distanceCIE76($input2);

        static::assertSame($expectedValue, $sut);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorRGBA|float>>
     */
    public function dataProviderForDistanceCIE76(): array
    {
        return [
            [new ColorRGBA(0, 0, 0), new ColorRGBA(0, 0, 0), 0],
            [new ColorRGBA(0, 0, 0), new ColorRGBA(255, 253, 155), 109.1308],
            [new ColorRGBA(255, 62, 0), new ColorRGBA(0, 59, 195), 147.8757],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::__toString
     *
     * @dataProvider dataProviderForToString
     */
    public function testToString(ColorRGBA $sut, string $expectedOutput): void
    {
        $output = (string) $sut;

        static::assertSame($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorRGBA|string>>
     */
    public function dataProviderForToString(): array
    {
        $sources = include __DIR__ . '/DataSources/RGBA.php';

        return $sources['toString'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\ColorRGBA::toHex
     * @covers \Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForToHex
     */
    public function testToHex(ColorRGBA $sut, ColorHex $expectedOutput): void
    {
        $output = $sut->toHex();

        static::assertInstanceOf(ColorHex::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorRGBA|\Coloreeze\ColorHex>>
     */
    public function dataProviderForToHex(): array
    {
        $sources = include __DIR__ . '/DataSources/RGBA.php';

        return $sources['toHex'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
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
    public function testToInt(ColorRGBA $sut, ColorInt $expectedOutput): void
    {
        $output = $sut->toInt();

        static::assertInstanceOf(ColorInt::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorRGBA|\Coloreeze\ColorInt>>
     */
    public function dataProviderForToInt(): array
    {
        $sources = include __DIR__ . '/DataSources/RGBA.php';

        return $sources['toInt'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\ColorRGBA::toRGBA
     *
     * @dataProvider dataProviderForToRGBA
     */
    public function testToRGBA(ColorRGBA $sut, ColorRGBA $expectedOutput): void
    {
        $output = $sut->toRGBA();

        static::assertInstanceOf(ColorRGBA::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorRGBA|\Coloreeze\ColorRGBA>>
     */
    public function dataProviderForToRGBA(): array
    {
        $sources = include __DIR__ . '/DataSources/RGBA.php';

        return $sources['toRGBA'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorCMYK::__construct
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorHex::toCMYK
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::toCMYK
     * @covers \Coloreeze\ColorRGBA::toHex
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForToCMYK
     */
    public function testToCMYK(ColorRGBA $sut, ColorCMYK $expectedOutput): void
    {
        $output = $sut->toCMYK();

        static::assertInstanceOf(ColorCMYK::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorRGBA|\Coloreeze\ColorCMYK>>
     */
    public function dataProviderForToCMYK(): array
    {
        $sources = include __DIR__ . '/DataSources/RGBA.php';

        return $sources['toCMYK'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\ColorRGBA::toHSL
     * @covers \Coloreeze\ColorHSL::__construct
     *
     * @dataProvider dataProviderForToHSL
     */
    public function testToHSL(ColorRGBA $sut, ColorHSL $expectedOutput): void
    {
        $output = $sut->toHSL();

        static::assertInstanceOf(ColorHSL::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorRGBA|\Coloreeze\ColorHSL>>
     */
    public function dataProviderForToHSL(): array
    {
        $sources = include __DIR__ . '/DataSources/RGBA.php';

        return $sources['toHSL'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\ColorRGBA::toXYZ
     * @covers \Coloreeze\ColorXYZ::__construct
     *
     * @dataProvider dataProviderForToXYZ
     */
    public function testToXYZ(ColorRGBA $sut, ColorXYZ $expectedOutput): void
    {
        $output = $sut->toXYZ();

        static::assertInstanceOf(ColorXYZ::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorRGBA|\Coloreeze\ColorXYZ>>
     */
    public function dataProviderForToXYZ(): array
    {
        $sources = include __DIR__ . '/DataSources/RGBA.php';

        return $sources['toXYZ'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\ColorRGBA::toHSB
     * @covers \Coloreeze\ColorHSB::__construct
     *
     * @dataProvider dataProviderForToHSB
     */
    public function testToHSB(ColorRGBA $sut, ColorHSB $expectedOutput): void
    {
        $output = $sut->toHSB();

        static::assertInstanceOf(ColorHSB::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorRGBA|\Coloreeze\ColorHSB>>
     */
    public function dataProviderForToHSB(): array
    {
        $sources = include __DIR__ . '/DataSources/RGBA.php';

        return $sources['toHSB'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorCIELab::__construct
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::toCIELab
     * @covers \Coloreeze\ColorRGBA::toXYZ
     * @covers \Coloreeze\ColorXYZ::__construct
     * @covers \Coloreeze\ColorXYZ::toCIELab
     *
     * @dataProvider dataProviderForToCIELab
     */
    public function testToCIELab(ColorRGBA $sut, ColorCIELab $expectedOutput): void
    {
        $output = $sut->toCIELab();

        static::assertInstanceOf(ColorCIELab::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorRGBA|\Coloreeze\ColorCIELab>>
     */
    public function dataProviderForToCIELab(): array
    {
        $sources = include __DIR__ . '/DataSources/RGBA.php';

        return $sources['toCIELab'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::toGreyscale
     *
     * @dataProvider dataProviderForToGreyscale
     */
    public function testToGreyscale(ColorRGBA $sut, ColorRGBA $expectedOutput): void
    {
        $output = $sut->toGreyscale();

        static::assertInstanceOf(ColorRGBA::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorRGBA>>
     */
    public function dataProviderForToGreyscale(): array
    {
        $sources = include __DIR__ . '/DataSources/RGBA.php';

        return $sources['toGreyscale'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::toComplementary
     *
     * @dataProvider dataProviderForToComplementary
     */
    public function testToComplementary(ColorRGBA $sut, ColorRGBA $expectedOutput): void
    {
        $output = $sut->toComplementary();

        static::assertInstanceOf(ColorRGBA::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorRGBA>>
     */
    public function dataProviderForToComplementary(): array
    {
        $sources = include __DIR__ . '/DataSources/RGBA.php';

        return $sources['toComplementary'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::adjustBrightness
     *
     * @dataProvider dataProviderForToDarker
     */
    public function testToDarker(ColorRGBA $sut, ColorRGBA $expectedOutput): void
    {
        $output = $sut->adjustBrightness(-25);

        static::assertInstanceOf(ColorRGBA::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorRGBA>>
     */
    public function dataProviderForToDarker(): array
    {
        $sources = include __DIR__ . '/DataSources/RGBA.php';

        return $sources['toDarker'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::adjustBrightness
     *
     * @dataProvider dataProviderForToLighter
     */
    public function testToLighter(ColorRGBA $sut, ColorRGBA $expectedOutput): void
    {
        $output = $sut->adjustBrightness(25);

        static::assertInstanceOf(ColorRGBA::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorRGBA>>
     */
    public function dataProviderForToLighter(): array
    {
        $sources = include __DIR__ . '/DataSources/RGBA.php';

        return $sources['toLighter'];
    }
}
