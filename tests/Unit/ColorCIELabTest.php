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
final class ColorCIELabTest extends TestCase
{
    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorCIELab::__construct
     * @covers \Fonil\Coloreeze\Exceptions\InvalidInput::notInRange
     * @covers \Fonil\Coloreeze\Color::isInRange
     *
     * @dataProvider dataProviderForValidation
     */
    public function testValidation(float $l, float $a, float $b): void
    {
        static::expectException(InvalidInput::class);

        new ColorCIELab($l, $a, $b);
    }

    /**
     * @return array<int, array<int, int|float>>
     */
    public function dataProviderForValidation(): array
    {
        return [
            [ColorCIELab::VALUE_MIN__L - 1, 0, 0],
            [ColorCIELab::VALUE_MAX__L + 1, 0, 0],
            [0, ColorCIELab::VALUE_MIN__A - 1, 0],
            [0, ColorCIELab::VALUE_MAX__A + 1, 0],
            [0, 0, ColorCIELab::VALUE_MIN__B - 1],
            [0, 0, ColorCIELab::VALUE_MAX__B + 1],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @param array<int> $expectedValue
     *
     * @covers \Fonil\Coloreeze\ColorCIELab::__construct
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\ColorCIELab::getValue
     *
     * @dataProvider dataProviderForEntity
     */
    public function testEntity(float $l, float $a, float $b, array $expectedValue): void
    {
        $sut = new ColorCIELab($l, $a, $b);

        static::assertInstanceOf(ColorCIELab::class, $sut);
        static::assertSame($expectedValue, $sut->getValue());
    }

    /**
     * @return array<int, array<int, array<int, float>|int>>
     */
    public function dataProviderForEntity(): array
    {
        return [
            [0, 0, 0, [0.0000, 0.0000, 0.0000]],
            [100, 100, 0, [100.0000, 100.0000, 0.0000]],
            [30, -100, -100, [30.0000, -100.0000, -100.0000]],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @param array<int, array<int, array<int, float>|string>> $expectedValue
     *
     * @covers \Fonil\Coloreeze\ColorCIELab::__construct
     * @covers \Fonil\Coloreeze\ColorCIELab::fromString
     * @covers \Fonil\Coloreeze\ColorCIELab::getValue
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForFromString
     */
    public function testFromString(string $inputValue, array $expectedValue): void
    {
        $sut = ColorCIELab::fromString($inputValue);

        static::assertInstanceOf(ColorCIELab::class, $sut);
        static::assertSame($expectedValue, $sut->getValue());
    }

    /**
     * @return array<int, array<int, array<int, float>|string>>
     */
    public function dataProviderForFromString(): array
    {
        return [
            ['CIELab(0,0,0)', [0.0000, 0.0000, 0.0000]],
            ['CIELab(100,100,100)', [100.0000, 100.0000, 100.0000]],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorCIELab::__construct
     * @covers \Fonil\Coloreeze\ColorCIELab::__toString
     * @covers \Fonil\Coloreeze\ColorCIELab::distanceCIE76
     *
     * @dataProvider dataProviderForDistanceCIE76
     */
    public function testDistanceCIE76(ColorCIELab $input1, ColorCIELab $input2, float $expectedValue): void
    {
        $sut = $input1->distanceCIE76($input2);

        static::assertSame($expectedValue, $sut);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorCIELab|float>>
     */
    public function dataProviderForDistanceCIE76(): array
    {
        return [
            [new ColorCIELab(0, 0, 0), new ColorCIELab(0, 0, 0), 0],
            [new ColorCIELab(0, 0, 0), new ColorCIELab(100, 0, 50), 111.8034],
            [new ColorCIELab(0, 110, 110), new ColorCIELab(100, -110, -110), 326.8027],
        ];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\ColorCIELab::__construct
     * @covers \Fonil\Coloreeze\ColorCIELab::__toString
     *
     * @dataProvider dataProviderForToString
     */
    public function testToString(ColorCIELab $sut, string $expectedOutput): void
    {
        $output = (string) $sut;

        static::assertSame($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorCIELab|string>>
     */
    public function dataProviderForToString(): array
    {
        $sources = include __DIR__ . '/DataSources/CIELab.php';

        return $sources['toString'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorCIELab::__construct
     * @covers \Fonil\Coloreeze\ColorCIELab::toHex
     * @covers \Fonil\Coloreeze\ColorCIELab::toXYZ
     * @covers \Fonil\Coloreeze\ColorHex::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::toHex
     * @covers \Fonil\Coloreeze\ColorXYZ::__construct
     * @covers \Fonil\Coloreeze\ColorXYZ::toHex
     * @covers \Fonil\Coloreeze\ColorXYZ::toRGBA
     * @covers \Fonil\Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForToHex
     */
    public function testToHex(ColorCIELab $sut, ColorHex $expectedOutput): void
    {
        $output = $sut->toHex();

        static::assertInstanceOf(ColorHex::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorCIELab|\Fonil\Coloreeze\ColorHex>>
     */
    public function dataProviderForToHex(): array
    {
        $sources = include __DIR__ . '/DataSources/CIELab.php';

        return $sources['toHex'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorCIELab::__construct
     * @covers \Fonil\Coloreeze\ColorCIELab::toInt
     * @covers \Fonil\Coloreeze\ColorCIELab::toXYZ
     * @covers \Fonil\Coloreeze\ColorHex::__construct
     * @covers \Fonil\Coloreeze\ColorHex::toInt
     * @covers \Fonil\Coloreeze\ColorInt::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::toHex
     * @covers \Fonil\Coloreeze\ColorXYZ::__construct
     * @covers \Fonil\Coloreeze\ColorXYZ::toInt
     * @covers \Fonil\Coloreeze\ColorXYZ::toRGBA
     * @covers \Fonil\Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForToInt
     */
    public function testToInt(ColorCIELab $sut, ColorInt $expectedOutput): void
    {
        $output = $sut->toInt();

        static::assertInstanceOf(ColorInt::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorCIELab|\Fonil\Coloreeze\ColorInt>>
     */
    public function dataProviderForToInt(): array
    {
        $sources = include __DIR__ . '/DataSources/CIELab.php';

        return $sources['toInt'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorCIELab::__construct
     * @covers \Fonil\Coloreeze\ColorCIELab::toRGBA
     * @covers \Fonil\Coloreeze\ColorCIELab::toXYZ
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorXYZ::__construct
     * @covers \Fonil\Coloreeze\ColorXYZ::toRGBA
     *
     * @dataProvider dataProviderForToRGBA
     */
    public function testToRGBA(ColorCIELab $sut, ColorRGBA $expectedOutput): void
    {
        $output = $sut->toRGBA();

        static::assertInstanceOf(ColorRGBA::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorCIELab|\Fonil\Coloreeze\ColorRGBA>>
     */
    public function dataProviderForToRGBA(): array
    {
        $sources = include __DIR__ . '/DataSources/CIELab.php';

        return $sources['toRGBA'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorCIELab::__construct
     * @covers \Fonil\Coloreeze\ColorCIELab::toCMYK
     * @covers \Fonil\Coloreeze\ColorCIELab::toXYZ
     * @covers \Fonil\Coloreeze\ColorCMYK::__construct
     * @covers \Fonil\Coloreeze\ColorHex::__construct
     * @covers \Fonil\Coloreeze\ColorHex::toCMYK
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::toHex
     * @covers \Fonil\Coloreeze\ColorXYZ::__construct
     * @covers \Fonil\Coloreeze\ColorXYZ::toCMYK
     * @covers \Fonil\Coloreeze\ColorXYZ::toRGBA
     * @covers \Fonil\Coloreeze\Color::validateFormat
     *
     * @dataProvider dataProviderForToCMYK
     */
    public function testToCMYK(ColorCIELab $sut, ColorCMYK $expectedOutput): void
    {
        $output = $sut->toCMYK();

        static::assertInstanceOf(ColorCMYK::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorCIELab|\Fonil\Coloreeze\ColorCMYK>>
     */
    public function dataProviderForToCMYK(): array
    {
        $sources = include __DIR__ . '/DataSources/CIELab.php';

        return $sources['toCMYK'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorCIELab::__construct
     * @covers \Fonil\Coloreeze\ColorCIELab::toHSL
     * @covers \Fonil\Coloreeze\ColorCIELab::toXYZ
     * @covers \Fonil\Coloreeze\ColorHSL::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::toHSL
     * @covers \Fonil\Coloreeze\ColorXYZ::__construct
     * @covers \Fonil\Coloreeze\ColorXYZ::toHSL
     * @covers \Fonil\Coloreeze\ColorXYZ::toRGBA
     *
     * @dataProvider dataProviderForToHSL
     */
    public function testToHSL(ColorCIELab $sut, ColorHSL $expectedOutput): void
    {
        $output = $sut->toHSL();

        static::assertInstanceOf(ColorHSL::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorCIELab|\Fonil\Coloreeze\ColorHSL>>
     */
    public function dataProviderForToHSL(): array
    {
        $sources = include __DIR__ . '/DataSources/CIELab.php';

        return $sources['toHSL'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorCIELab::__construct
     * @covers \Fonil\Coloreeze\ColorCIELab::toXYZ
     * @covers \Fonil\Coloreeze\ColorXYZ::__construct
     *
     * @dataProvider dataProviderForToXYZ
     */
    public function testToXYZ(ColorCIELab $sut, ColorXYZ $expectedOutput): void
    {
        $output = $sut->toXYZ();

        static::assertInstanceOf(ColorXYZ::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorCIELab|\Fonil\Coloreeze\ColorXYZ>>
     */
    public function dataProviderForToXYZ(): array
    {
        $sources = include __DIR__ . '/DataSources/CIELab.php';

        return $sources['toXYZ'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorCIELab::__construct
     * @covers \Fonil\Coloreeze\ColorCIELab::toHSB
     * @covers \Fonil\Coloreeze\ColorCIELab::toXYZ
     * @covers \Fonil\Coloreeze\ColorHSB::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::toHSB
     * @covers \Fonil\Coloreeze\ColorXYZ::__construct
     * @covers \Fonil\Coloreeze\ColorXYZ::toHSB
     * @covers \Fonil\Coloreeze\ColorXYZ::toRGBA
     *
     * @dataProvider dataProviderForToHSB
     */
    public function testToHSB(ColorCIELab $sut, ColorHSB $expectedOutput): void
    {
        $output = $sut->toHSB();

        static::assertInstanceOf(ColorHSB::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorCIELab|\Fonil\Coloreeze\ColorHSB>>
     */
    public function dataProviderForToHSB(): array
    {
        $sources = include __DIR__ . '/DataSources/CIELab.php';

        return $sources['toHSB'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorCIELab::__construct
     * @covers \Fonil\Coloreeze\ColorCIELab::toCIELab
     *
     * @dataProvider dataProviderForToCIELab
     */
    public function testToCIELab(ColorCIELab $sut, ColorCIELab $expectedOutput): void
    {
        $output = $sut->toCIELab();

        static::assertInstanceOf(ColorCIELab::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorCIELab|\Fonil\Coloreeze\ColorCIELab>>
     */
    public function dataProviderForToCIELab(): array
    {
        $sources = include __DIR__ . '/DataSources/CIELab.php';

        return $sources['toCIELab'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorCIELab::__construct
     * @covers \Fonil\Coloreeze\ColorCIELab::toGreyscale
     * @covers \Fonil\Coloreeze\ColorCIELab::toRGBA
     * @covers \Fonil\Coloreeze\ColorCIELab::toXYZ
     * @covers \Fonil\Coloreeze\ColorHex::__construct
     * @covers \Fonil\Coloreeze\ColorHex::toCIELab
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::toCIELab
     * @covers \Fonil\Coloreeze\ColorRGBA::toGreyscale
     * @covers \Fonil\Coloreeze\ColorRGBA::toHex
     * @covers \Fonil\Coloreeze\ColorRGBA::toXYZ
     * @covers \Fonil\Coloreeze\ColorXYZ::__construct
     * @covers \Fonil\Coloreeze\ColorXYZ::toCIELab
     * @covers \Fonil\Coloreeze\ColorXYZ::toRGBA
     *
     * @dataProvider dataProviderForToGreyscale
     */
    public function testToGreyscale(ColorCIELab $sut, ColorCIELab $expectedOutput): void
    {
        $output = $sut->toGreyscale();

        static::assertInstanceOf(ColorCIELab::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorCIELab>>
     */
    public function dataProviderForToGreyscale(): array
    {
        $sources = include __DIR__ . '/DataSources/CIELab.php';

        return $sources['toGreyscale'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorCIELab::__construct
     * @covers \Fonil\Coloreeze\ColorCIELab::toComplementary
     * @covers \Fonil\Coloreeze\ColorCIELab::toRGBA
     * @covers \Fonil\Coloreeze\ColorCIELab::toXYZ
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::toCIELab
     * @covers \Fonil\Coloreeze\ColorRGBA::toComplementary
     * @covers \Fonil\Coloreeze\ColorRGBA::toXYZ
     * @covers \Fonil\Coloreeze\ColorXYZ::__construct
     * @covers \Fonil\Coloreeze\ColorXYZ::toCIELab
     * @covers \Fonil\Coloreeze\ColorXYZ::toRGBA
     *
     * @dataProvider dataProviderForToComplementary
     */
    public function testToComplementary(ColorCIELab $sut, ColorCIELab $expectedOutput): void
    {
        $output = $sut->toComplementary();

        static::assertInstanceOf(ColorCIELab::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorCIELab>>
     */
    public function dataProviderForToComplementary(): array
    {
        $sources = include __DIR__ . '/DataSources/CIELab.php';

        return $sources['toComplementary'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorCIELab::__construct
     * @covers \Fonil\Coloreeze\ColorCIELab::adjustBrightness
     * @covers \Fonil\Coloreeze\ColorCIELab::toRGBA
     * @covers \Fonil\Coloreeze\ColorCIELab::toXYZ
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::adjustBrightness
     * @covers \Fonil\Coloreeze\ColorRGBA::toCIELab
     * @covers \Fonil\Coloreeze\ColorRGBA::toXYZ
     * @covers \Fonil\Coloreeze\ColorXYZ::__construct
     * @covers \Fonil\Coloreeze\ColorXYZ::toCIELab
     * @covers \Fonil\Coloreeze\ColorXYZ::toRGBA
     *
     * @dataProvider dataProviderForToDarker
     */
    public function testToDarker(ColorCIELab $sut, ColorCIELab $expectedOutput): void
    {
        $output = $sut->adjustBrightness(-25);

        static::assertInstanceOf(ColorCIELab::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorCIELab>>
     */
    public function dataProviderForToDarker(): array
    {
        $sources = include __DIR__ . '/DataSources/CIELab.php';

        return $sources['toDarker'];
    }

    //-----------------------------------------------------------------------------------------------------------------

    /**
     * @covers \Fonil\Coloreeze\Color::isInRange
     * @covers \Fonil\Coloreeze\Color::validateIsInRange
     * @covers \Fonil\Coloreeze\ColorCIELab::__construct
     * @covers \Fonil\Coloreeze\ColorCIELab::adjustBrightness
     * @covers \Fonil\Coloreeze\ColorCIELab::toRGBA
     * @covers \Fonil\Coloreeze\ColorCIELab::toXYZ
     * @covers \Fonil\Coloreeze\ColorRGBA::__construct
     * @covers \Fonil\Coloreeze\ColorRGBA::adjustBrightness
     * @covers \Fonil\Coloreeze\ColorRGBA::toCIELab
     * @covers \Fonil\Coloreeze\ColorRGBA::toXYZ
     * @covers \Fonil\Coloreeze\ColorXYZ::__construct
     * @covers \Fonil\Coloreeze\ColorXYZ::toCIELab
     * @covers \Fonil\Coloreeze\ColorXYZ::toRGBA
     *
     * @dataProvider dataProviderForToLighter
     */
    public function testToLighter(ColorCIELab $sut, ColorCIELab $expectedOutput): void
    {
        $output = $sut->adjustBrightness(25);

        static::assertInstanceOf(ColorCIELab::class, $output);
        static::assertEquals($expectedOutput, $output);
    }

    /**
     * @return array<int, array<int, \Fonil\Coloreeze\ColorCIELab>>
     */
    public function dataProviderForToLighter(): array
    {
        $sources = include __DIR__ . '/DataSources/CIELab.php';

        return $sources['toLighter'];
    }
}
