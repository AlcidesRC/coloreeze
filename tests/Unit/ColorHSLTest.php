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
final class ColorHSLTest extends TestCase
{
    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorHSL::__construct
     * @covers \Coloreeze\Exceptions\InvalidInput::notInRange
     * @covers \Coloreeze\Color::isInRange
     *
     * @dataProvider dataProviderForValidation
     */
    public function testValidation(int $hue, int $saturation, int $lightness): void
    {
        static::expectException(InvalidInput::class);

        new ColorHSL($hue, $saturation, $lightness);
    }

    /**
     * @return array<int, array<int, int>>
     */
    public function dataProviderForValidation(): array
    {
        return [
            [ColorHSL::VALUE_MIN__HUE - 1, 0, 0],
            [ColorHSL::VALUE_MAX__HUE + 1, 0, 0],
            [0, ColorHSL::VALUE_MIN__SATURATION - 1, 0],
            [0, ColorHSL::VALUE_MAX__SATURATION + 1, 0],
            [0, 0, ColorHSL::VALUE_MIN__LIGHTNESS - 1],
            [0, 0, ColorHSL::VALUE_MAX__LIGHTNESS + 1],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @param array<int|float> $expectedValue
     *
     * @covers \Coloreeze\ColorHSL::__construct
     * @covers \Coloreeze\ColorHSL::getValue
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\Color::isInRange
     *
     * @dataProvider dataProviderForEntity
     */
    public function testEntity(int $hue, float $saturation, float $value, array $expectedValue): void
    {
        $sut = new ColorHSL($hue, $saturation, $value);

        static::assertInstanceOf(ColorHSL::class, $sut);
        static::assertSame($expectedValue, $sut->getValue());
    }

    /**
     * @return array<int, array<int, array<int, float>|int>>
     */
    public function dataProviderForEntity(): array
    {
        return [
            [0, 0, 0, [0.0, 0.0, 0.0]],
            [240, 100, 3, [240.0, 100.0, 3.0]],
            [240, 100, 50, [240.0, 100.0, 50.0]],
            [236, 100, 50, [236.0, 100.0, 50.0]],
            [180, 100, 50, [180.0, 100.0, 50.0]],
            [180, 100, 53, [180.0, 100.0, 53.0]],
            [0, 0, 100, [0.0, 0.0, 100.0]],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @param array<int, array<int, array<int, float>|string>> $expectedValue
     *
     * @covers \Coloreeze\ColorHSL::__construct
     * @covers \Coloreeze\ColorHSL::fromString
     * @covers \Coloreeze\ColorHSL::getValue
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForFromString
     */
    public function testFromString(string $inputValue, array $expectedValue): void
    {
        $sut = ColorHSL::fromString($inputValue);

        static::assertInstanceOf(ColorHSL::class, $sut);
        static::assertSame($expectedValue, $sut->getValue());
    }

    /**
     * @return array<int, array<int, array<int, float>|string>>
     */
    public function dataProviderForFromString(): array
    {
        return [
            ['hsl(0,0,0)', [0.0000, 0.0000, 0.0000]],
            ['hsl(255,100,100)', [255.0000, 100.0000, 100.0000]],
            ['hsl(0,0%,0%)', [0.0000, 0.0000, 0.0000]],
            ['hsl(255,100%,100%)', [255.0000, 100.0000, 100.0000]],
            ['hsl(33,66,99)', [33.0000, 66.0000, 99.0000]],
            ['hsl(33,66%,99%)', [33.0000, 66.0000, 99.0000]],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorCIELab::__construct
     * @covers \Coloreeze\ColorCIELab::__toString
     * @covers \Coloreeze\ColorCIELab::distanceCIE76
     * @covers \Coloreeze\ColorHSL::distanceCIE76
     * @covers \Coloreeze\ColorHSL::toCIELab
     * @covers \Coloreeze\ColorHSL::toRGBA
     * @covers \Coloreeze\ColorHSL::toXYZ
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::toXYZ
     * @covers \Coloreeze\ColorXYZ::__construct
     * @covers \Coloreeze\ColorXYZ::toCIELab
     *
     * @dataProvider dataProviderForDistanceCIE76
     */
    public function testDistanceCIE76(ColorHSL $input1, ColorHSL $input2, float $expectedValue): void
    {
        $sut = $input1->distanceCIE76($input2);

        static::assertSame($expectedValue, $sut);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHSL|float>>
     */
    public function dataProviderForDistanceCIE76(): array
    {
        return [
            [new ColorHSL(0, 0, 0), new ColorHSL(0, 0, 0), 0],
            [new ColorHSL(0, 0, 0), new ColorHSL(59, 100, 80), 109.5367],
            [new ColorHSL(15, 100, 50), new ColorHSL(222, 100, 38), 147.8561],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\ColorHSL::__construct
     * @covers \Coloreeze\ColorHSL::__toString
     *
     * @dataProvider dataProviderForToString
     */
    public function testToString(ColorHSL $sut, string $expectedOutput): void
    {
        $output = (string) $sut;

        static::assertSame($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHSL|string>>
     */
    public function dataProviderForToString(): array
    {
        $sources = include __DIR__ . '/DataSources/HSL.php';

        return $sources['toString'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorHSL::__construct
     * @covers \Coloreeze\ColorHSL::toHex
     * @covers \Coloreeze\ColorHSL::toRGBA
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\ColorRGBA::toHex
     * @covers \Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForToHex
     */
    public function testToHex(ColorHSL $sut, ColorHex $expectedOutput): void
    {
        $output = $sut->toHex();

        static::assertInstanceOf(ColorHex::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHSL|\Coloreeze\ColorHex>>
     */
    public function dataProviderForToHex(): array
    {
        $sources = include __DIR__ . '/DataSources/HSL.php';

        return $sources['toHex'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorHex::toInt
     * @covers \Coloreeze\ColorHSL::__construct
     * @covers \Coloreeze\ColorHSL::toHex
     * @covers \Coloreeze\ColorHSL::toInt
     * @covers \Coloreeze\ColorHSL::toRGBA
     * @covers \Coloreeze\ColorInt::__construct
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\ColorRGBA::toHex
     * @covers \Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForToInt
     */
    public function testToInt(ColorHSL $sut, ColorInt $expectedOutput): void
    {
        $output = $sut->toInt();

        static::assertInstanceOf(ColorInt::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHSL|\Coloreeze\ColorInt>>
     */
    public function dataProviderForToInt(): array
    {
        $sources = include __DIR__ . '/DataSources/HSL.php';

        return $sources['toInt'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\ColorHSL::__construct
     * @covers \Coloreeze\ColorHSL::toRGBA
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\Color::isInRange
     *
     * @dataProvider dataProviderForToRGBA
     */
    public function testToRGBA(ColorHSL $sut, ColorRGBA $expectedOutput): void
    {
        $output = $sut->toRGBA();

        static::assertInstanceOf(ColorRGBA::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHSL|\Coloreeze\ColorRGBA>>
     */
    public function dataProviderForToRGBA(): array
    {
        $sources = include __DIR__ . '/DataSources/HSL.php';

        return $sources['toRGBA'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorCMYK::__construct
     * @covers \Coloreeze\ColorHex::__construct
     * @covers \Coloreeze\ColorHex::toCMYK
     * @covers \Coloreeze\ColorHSL::__construct
     * @covers \Coloreeze\ColorHSL::toCMYK
     * @covers \Coloreeze\ColorHSL::toHex
     * @covers \Coloreeze\ColorHSL::toRGBA
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::toCMYK
     * @covers \Coloreeze\ColorRGBA::toHex
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForToCMYK
     */
    public function testToCMYK(ColorHSL $sut, ColorCMYK $expectedOutput): void
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
        $sources = include __DIR__ . '/DataSources/HSL.php';

        return $sources['toCMYK'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\ColorHSL::__construct
     * @covers \Coloreeze\ColorHSL::toHSL
     *
     * @dataProvider dataProviderForToHSL
     */
    public function testToHSL(ColorHSL $sut, ColorHSL $expectedOutput): void
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
        $sources = include __DIR__ . '/DataSources/HSL.php';

        return $sources['toHSL'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorHSL::__construct
     * @covers \Coloreeze\ColorHSL::toRGBA
     * @covers \Coloreeze\ColorHSL::toXYZ
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::toXYZ
     * @covers \Coloreeze\ColorXYZ::__construct
     * @covers \Coloreeze\Color::isInRange
     *
     * @dataProvider dataProviderForToXYZ
     */
    public function testToXYZ(ColorHSL $sut, ColorXYZ $expectedOutput): void
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
        $sources = include __DIR__ . '/DataSources/HSL.php';

        return $sources['toXYZ'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorHSB::__construct
     * @covers \Coloreeze\ColorHSL::__construct
     * @covers \Coloreeze\ColorHSL::toHSB
     * @covers \Coloreeze\ColorHSL::toRGBA
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::toHSB
     *
     * @dataProvider dataProviderForToHSB
     */
    public function testToHSB(ColorHSL $sut, ColorHSB $expectedOutput): void
    {
        $output = $sut->toHSB();

        static::assertInstanceOf(ColorHSB::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHSL|\Coloreeze\ColorHSB>>
     */
    public function dataProviderForToHSB(): array
    {
        $sources = include __DIR__ . '/DataSources/HSL.php';

        return $sources['toHSB'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorCIELab::__construct
     * @covers \Coloreeze\ColorHSL::toCIELab
     * @covers \Coloreeze\ColorHSL::toRGBA
     * @covers \Coloreeze\ColorHSL::toXYZ
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::toXYZ
     * @covers \Coloreeze\ColorXYZ::__construct
     * @covers \Coloreeze\ColorXYZ::toCIELab
     *
     * @dataProvider dataProviderForToCIELab
     */
    public function testToCIELab(ColorHSL $sut, ColorCIELab $expectedOutput): void
    {
        $output = $sut->toCIELab();

        static::assertInstanceOf(ColorCIELab::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHSL|\Coloreeze\ColorCIELab>>
     */
    public function dataProviderForToCIELab(): array
    {
        $sources = include __DIR__ . '/DataSources/HSL.php';

        return $sources['toCIELab'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorHSL::__construct
     * @covers \Coloreeze\ColorHSL::toGreyscale
     * @covers \Coloreeze\ColorHSL::toRGBA
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::toGreyscale
     * @covers \Coloreeze\ColorRGBA::toHSL
     *
     * @dataProvider dataProviderForToGreyscale
     */
    public function testToGreyscale(ColorHSL $sut, ColorHSL $expectedOutput): void
    {
        $output = $sut->toGreyscale();

        static::assertInstanceOf(ColorHSL::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHSL>>
     */
    public function dataProviderForToGreyscale(): array
    {
        $sources = include __DIR__ . '/DataSources/HSL.php';

        return $sources['toGreyscale'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorHSL::__construct
     * @covers \Coloreeze\ColorHSL::toComplementary
     * @covers \Coloreeze\ColorHSL::toRGBA
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::toComplementary
     * @covers \Coloreeze\ColorRGBA::toHSL
     *
     * @dataProvider dataProviderForToComplementary
     */
    public function testToComplementary(ColorHSL $sut, ColorHSL $expectedOutput): void
    {
        $output = $sut->toComplementary();

        static::assertInstanceOf(ColorHSL::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHSL>>
     */
    public function dataProviderForToComplementary(): array
    {
        $sources = include __DIR__ . '/DataSources/HSL.php';

        return $sources['toComplementary'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorHSL::__construct
     * @covers \Coloreeze\ColorHSL::adjustBrightness
     * @covers \Coloreeze\ColorHSL::toRGBA
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::adjustBrightness
     * @covers \Coloreeze\ColorRGBA::toHSL
     *
     * @dataProvider dataProviderForToDarker
     */
    public function testToDarker(ColorHSL $sut, ColorHSL $expectedOutput): void
    {
        $output = $sut->adjustBrightness(-25);

        static::assertInstanceOf(ColorHSL::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHSL>>
     */
    public function dataProviderForToDarker(): array
    {
        $sources = include __DIR__ . '/DataSources/HSL.php';

        return $sources['toDarker'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Coloreeze\Color::isInRange
     * @covers \Coloreeze\Color::validateIsInRange
     * @covers \Coloreeze\ColorHSL::__construct
     * @covers \Coloreeze\ColorHSL::adjustBrightness
     * @covers \Coloreeze\ColorHSL::toRGBA
     * @covers \Coloreeze\ColorRGBA::__construct
     * @covers \Coloreeze\ColorRGBA::adjustBrightness
     * @covers \Coloreeze\ColorRGBA::toHSL
     *
     * @dataProvider dataProviderForToLighter
     */
    public function testToLighter(ColorHSL $sut, ColorHSL $expectedOutput): void
    {
        $output = $sut->adjustBrightness(25);

        static::assertInstanceOf(ColorHSL::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Coloreeze\ColorHSL>>
     */
    public function dataProviderForToLighter(): array
    {
        $sources = include __DIR__ . '/DataSources/HSL.php';

        return $sources['toLighter'];
    }
}
