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
final class ColorHSBTest extends TestCase
{
    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorHSB::__construct
     * @covers \Coloreeze\Exceptions\InvalidInput::notInRange
     * @covers \Coloreeze\Color::isInRange
     *
     * @dataProvider dataProviderForValidation
     */
    public function testValidation(float $hue, int $saturation, int $brightness): void
    {
        static::expectException(InvalidInput::class);

        new ColorHSB($hue, $saturation, $brightness);
    }

    /**
     * @return array<int, array<int, int>>
     */
    public function dataProviderForValidation(): array
    {
        return [
            [ColorHSB::VALUE_MIN__HUE - 1, 0, 0],
            [ColorHSB::VALUE_MAX__HUE + 1, 0, 0],
            [0, ColorHSB::VALUE_MIN__SATURATION - 1, 0],
            [0, ColorHSB::VALUE_MAX__SATURATION + 1, 0],
            [0, 0, ColorHSB::VALUE_MIN__BRIGHTNESS - 1],
            [0, 0, ColorHSB::VALUE_MAX__BRIGHTNESS + 1],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @param array<int|float> $expectedValue
     *
     * @covers \Coloreeze\ColorHSB::__construct
     * @covers \Coloreeze\ColorHSB::getValue
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\Color::isInRange
     *
     * @dataProvider dataProviderForEntity
     */
    public function testEntity(float $hue, int $saturation, int $brightness, array $expectedValue): void
    {
        $sut = new ColorHSB($hue, $saturation, $brightness);

        static::assertInstanceOf(ColorHSB::class, $sut);
        static::assertSame($expectedValue, $sut->getValue());
    }

    /**
     * @return array<int, array<int, array<int, float>|int>>
     */
    public function dataProviderForEntity(): array
    {
        return [
            [0, 0, 0, [0.0000, 0.0000, 0.0000]],
            [240, 100, 3, [240.0000, 100.0000, 3.0000]],
            [240, 100, 50, [240.0000, 100.0000, 50.0000]],
            [236, 100, 50, [236.0000, 100.0000, 50.0000]],
            [180, 100, 50, [180.0000, 100.0000, 50.0000]],
            [180, 100, 53, [180.0000, 100.0000, 53.0000]],
            [0, 0, 100, [0.0000, 0.0000, 100.0000]],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @param array<int, array<int, array<int, float>|string>> $expectedValue
     *
     * @covers \Coloreeze\ColorHSB::__construct
     * @covers \Coloreeze\ColorHSB::fromString
     * @covers \Coloreeze\ColorHSB::getValue
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForFromString
     */
    public function testFromString(string $inputValue, array $expectedValue): void
    {
        $sut = ColorHSB::fromString($inputValue);

        static::assertInstanceOf(ColorHSB::class, $sut);
        static::assertSame($expectedValue, $sut->getValue());
    }

    /**
     * @return array<int, array<int, array<int, float>|string>>
     */
    public function dataProviderForFromString(): array
    {
        return [
            ['hsb(0,0,0)', [0.0000, 0.0000, 0.0000]],
            ['hsb(255,100,100)', [255.0000, 100.0000, 100.0000]],
            ['hsb(0,0%,0%)', [0.0000, 0.0000, 0.0000]],
            ['hsb(255,100%,100%)', [255.0000, 100.0000, 100.0000]],
            ['hsb(33,66,99)', [33.0000, 66.0000, 99.0000]],
            ['hsb(33,66%,99%)', [33.0000, 66.0000, 99.0000]],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorCIELab::__construct
     * @covers \Coloreeze\ColorCIELab::__toString
     * @covers \Coloreeze\ColorCIELab::distanceCIE76
     * @covers \Coloreeze\ColorHSB::distanceCIE76
     * @covers \Coloreeze\ColorHSB::toCIELab
     * @covers \Coloreeze\ColorHSB::toRGBA
     * @covers \Coloreeze\ColorHSB::toXYZ
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::toXYZ
     * @covers \Coloreeze\ColorXYZ::__construct
     * @covers \Coloreeze\ColorXYZ::toCIELab
     *
     * @dataProvider dataProviderForDistanceCIE76
     */
    public function testDistanceCIE76(ColorHSB $input1, ColorHSB $input2, float $expectedValue): void
    {
        $sut = $input1->distanceCIE76($input2);

        static::assertSame($expectedValue, $sut);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHSB|float>>
     */
    public function dataProviderForDistanceCIE76(): array
    {
        return [
            [new ColorHSB(0, 0, 0), new ColorHSB(0, 0, 0), 0],
            [new ColorHSB(0, 0, 0), new ColorHSB(59, 39, 100), 108.9302],
            [new ColorHSB(15, 100, 100), new ColorHSB(222, 100, 76), 147.8561],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\ColorHSB::__construct
     * @covers \Coloreeze\ColorHSB::__toString
     *
     * @dataProvider dataProviderForToString
     */
    public function testToString(ColorHSB $sut, string $expectedOutput): void
    {
        $output = (string) $sut;

        static::assertSame($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHSB|string>>
     */
    public function dataProviderForToString(): array
    {
        $sources = include __DIR__ . '/DataSources/HSB.php';

        return $sources['toString'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorHSB::__construct
     * @covers \Coloreeze\ColorHSB::toHex
     * @covers \Coloreeze\ColorHSB::toRGBA
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\ColorRGBA::toHex
     * @covers \Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForToHex
     */
    public function testToHex(ColorHSB $sut, ColorHex $expectedOutput): void
    {
        $output = $sut->toHex();

        static::assertInstanceOf(ColorHex::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHSB|\Coloreeze\ColorHex>>
     */
    public function dataProviderForToHex(): array
    {
        $sources = include __DIR__ . '/DataSources/HSB.php';

        return $sources['toHex'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorHex::toInt
     * @covers \Coloreeze\ColorHSB::__construct
     * @covers \Coloreeze\ColorHSB::toHex
     * @covers \Coloreeze\ColorHSB::toInt
     * @covers \Coloreeze\ColorHSB::toRGBA
     * @covers \Coloreeze\ColorInt::__construct
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::toInt
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\ColorRGBA::toHex
     * @covers \Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForToInt
     */
    public function testToInt(ColorHSB $sut, ColorInt $expectedOutput): void
    {
        $output = $sut->toInt();

        static::assertInstanceOf(ColorInt::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHSB|\Coloreeze\ColorInt>>
     */
    public function dataProviderForToInt(): array
    {
        $sources = include __DIR__ . '/DataSources/HSB.php';

        return $sources['toInt'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\ColorHSB::__construct
     * @covers \Coloreeze\ColorHSB::toRGBA
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\Color::isInRange
     *
     * @dataProvider dataProviderForToRGBA
     */
    public function testToRGBA(ColorHSB $sut, ColorRGBA $expectedOutput): void
    {
        $output = $sut->toRGBA();

        static::assertInstanceOf(ColorRGBA::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHSB|\Coloreeze\ColorRGBA>>
     */
    public function dataProviderForToRGBA(): array
    {
        $sources = include __DIR__ . '/DataSources/HSB.php';

        return $sources['toRGBA'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorCMYK::__construct
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorHex::toCMYK
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::toCMYK
     * @covers \Coloreeze\ColorRGBA::toHex
     * @covers \Coloreeze\ColorHSB::toCMYK
     * @covers \Coloreeze\ColorHSB::toRGBA
     * @covers \Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForToCMYK
     */
    public function testToCMYK(ColorHSB $sut, ColorCMYK $expectedOutput): void
    {
        $output = $sut->toCMYK();

        static::assertInstanceOf(ColorCMYK::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHSL|\Coloreeze\ColorCMYK>>
     */
    public function dataProviderForToCMYK(): array
    {
        $sources = include __DIR__ . '/DataSources/HSB.php';

        return $sources['toCMYK'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorHSB::toHSL
     * @covers \Coloreeze\ColorHSB::toRGBA
     * @covers \Coloreeze\ColorHSL::__construct
     * @covers \Coloreeze\ColorHSL::toHSL
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::toHSL
     *
     * @dataProvider dataProviderForToHSL
     */
    public function testToHSL(ColorHSB $sut, ColorHSL $expectedOutput): void
    {
        $output = $sut->toHSL();

        static::assertInstanceOf(ColorHSL::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHSL|\Coloreeze\ColorHSL>>
     */
    public function dataProviderForToHSL(): array
    {
        $sources = include __DIR__ . '/DataSources/HSB.php';

        return $sources['toHSL'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorHSB::__construct
     * @covers \Coloreeze\ColorHSB::toRGBA
     * @covers \Coloreeze\ColorHSB::toXYZ
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::toXYZ
     * @covers \Coloreeze\ColorXYZ::__construct
     * @covers \Coloreeze\Color::isInRange
     *
     * @dataProvider dataProviderForToXYZ
     */
    public function testToXYZ(ColorHSB $sut, ColorXYZ $expectedOutput): void
    {
        $output = $sut->toXYZ();

        static::assertInstanceOf(ColorXYZ::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHSL|\Coloreeze\ColorXYZ>>
     */
    public function dataProviderForToXYZ(): array
    {
        $sources = include __DIR__ . '/DataSources/HSB.php';

        return $sources['toXYZ'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorHSB::__construct
     * @covers \Coloreeze\ColorHSB::toHSB
     *
     * @dataProvider dataProviderForToHSB
     */
    public function testToHSB(ColorHSB $sut, ColorHSB $expectedOutput): void
    {
        $output = $sut->toHSB();

        static::assertInstanceOf(ColorHSB::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHSB|\Coloreeze\ColorHSB>>
     */
    public function dataProviderForToHSB(): array
    {
        $sources = include __DIR__ . '/DataSources/HSB.php';

        return $sources['toHSB'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorCIELab::__construct
     * @covers \Coloreeze\ColorHSB::toCIELab
     * @covers \Coloreeze\ColorHSB::toRGBA
     * @covers \Coloreeze\ColorHSB::toXYZ
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::toXYZ
     * @covers \Coloreeze\ColorXYZ::__construct
     * @covers \Coloreeze\ColorXYZ::toCIELab
     *
     * @dataProvider dataProviderForToCIELab
     */
    public function testToCIELab(ColorHSB $sut, ColorCIELab $expectedOutput): void
    {
        $output = $sut->toCIELab();

        static::assertInstanceOf(ColorCIELab::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHSB|\Coloreeze\ColorCIELab>>
     */
    public function dataProviderForToCIELab(): array
    {
        $sources = include __DIR__ . '/DataSources/HSB.php';

        return $sources['toCIELab'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorHSB::__construct
     * @covers \Coloreeze\ColorHSB::toGreyscale
     * @covers \Coloreeze\ColorHSB::toRGBA
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::toGreyscale
     * @covers \Coloreeze\ColorRGBA::toHSB
     * @covers \Coloreeze\ColorRGBA::toXYZ
     *
     * @dataProvider dataProviderForToGreyscale
     */
    public function testToGreyscale(ColorHSB $sut, ColorHSB $expectedOutput): void
    {
        $output = $sut->toGreyscale();

        static::assertInstanceOf(ColorHSB::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHSB>>
     */
    public function dataProviderForToGreyscale(): array
    {
        $sources = include __DIR__ . '/DataSources/HSB.php';

        return $sources['toGreyscale'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorHSB::__construct
     * @covers \Coloreeze\ColorHSB::toComplementary
     * @covers \Coloreeze\ColorHSB::toRGBA
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::toComplementary
     * @covers \Coloreeze\ColorRGBA::toHSB
     *
     * @dataProvider dataProviderForToComplementary
     */
    public function testToComplementary(ColorHSB $sut, ColorHSB $expectedOutput): void
    {
        $output = $sut->toComplementary();

        static::assertInstanceOf(ColorHSB::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHSB>>
     */
    public function dataProviderForToComplementary(): array
    {
        $sources = include __DIR__ . '/DataSources/HSB.php';

        return $sources['toComplementary'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorHSB::__construct
     * @covers \Coloreeze\ColorHSB::adjustBrightness
     * @covers \Coloreeze\ColorHSB::toRGBA
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::adjustBrightness
     * @covers \Coloreeze\ColorRGBA::toHSB
     *
     * @dataProvider dataProviderForToDarker
     */
    public function testToDarker(ColorHSB $sut, ColorHSB $expectedOutput): void
    {
        $output = $sut->adjustBrightness(-25);

        static::assertInstanceOf(ColorHSB::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHSB>>
     */
    public function dataProviderForToDarker(): array
    {
        $sources = include __DIR__ . '/DataSources/HSB.php';

        return $sources['toDarker'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorHSB::__construct
     * @covers \Coloreeze\ColorHSB::adjustBrightness
     * @covers \Coloreeze\ColorHSB::toRGBA
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::adjustBrightness
     * @covers \Coloreeze\ColorRGBA::toHSB
     *
     * @dataProvider dataProviderForToLighter
     */
    public function testToLighter(ColorHSB $sut, ColorHSB $expectedOutput): void
    {
        $output = $sut->adjustBrightness(25);

        static::assertInstanceOf(ColorHSB::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHSB>>
     */
    public function dataProviderForToLighter(): array
    {
        $sources = include __DIR__ . '/DataSources/HSB.php';

        return $sources['toLighter'];
    }
}
