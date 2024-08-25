[![Integration Tests](https://github.com/AlcidesRC/coloreeze/actions/workflows/ci.yml/badge.svg)](https://github.com/AlcidesRC/coloreeze/actions/workflows/ci.yml)

# coloreeze

> A PHP library to deal with color conversions

[TOC]

## Summary

Coloreeze is a PHP library to deal with color conversions.

Currently it supports the following color spaces:

- Hexadecimal
- Integer
- RGB(a)
- HSB/HSV
- HSL
- CMYK
- CIELab
- XYZ

## Features

Additionally this library contains some useful methods to:

- Generate a greyscale version from a color
- Generate a darker version from a color
- Generate a lighter version from a color
- to create gradients and measure the distance CIE76 between colors.

## Installation

You can install the package via composer:

```bash
$ composer require alcidesrc/coloreeze
```

## Usage

`Coloreeze` package contains independent color classes, all of them implementing a `Color` interface:

- ColorCIELab
- ColorCMYK
- ColorFactory
- ColorHSB
- ColorHSL
- ColorHex
- ColorInt
- ColorRGBA
- ColorXYZ

### Color Factory

#### ColorFactory::fromString(string $input): Color

The `ColorFactory` class allows you to create a color instance from any valid input string.

If the input string is not a valid color representation it throws an `InvalidInput` exception.

```php
ColorFactory::fromString('rgb(0,100,200)'); // Returns a `ColorRGBA` instance
ColorFactory::fromString('#336699'); // Returns a `ColorHex` instance
ColorFactory::fromString('unknown(1,2,3)'); // Throws an `InvalidInput` exception
```

### Color Interface

#### __toString(): string

Cast the color value to a string:

```php
echo ColorRGBA::fromString('rgba(0,100,200,1.0)');
echo ColorHex::fromString('#336699');

'rgba(0,100,200,1.0)'
'#336699'
```

#### fromString(string $input): Color

Parses an input string and returns accordingly the related `Color` implementation:

```php
$hex = ColorHex::fromString('#336699');
$rgba = ColorRGBA::fromString('rgba(0,100,200,1.0)');
...
```

It throws an `InvalidInput` exception in case of the string is not well formed or unsupported color.

#### getValue(): mixed

Returns the `Color` value. On single-value colors, this method returns a primitive value (int or string) but on composite ones it returns an array with color's components:

```php
$int = ColorInt::fromString('int(100)');
var_dump($int->getValue());

int(100)
```

```php
$rgba = ColorRGBA::fromString('rgba(0, 100, 200)');
var_dump($int->getValue());

array(3) {
  [0]=>
  int(0)
  [1]=>
  int(100)
  [2]=>
  int(200)
}
```

```php
$hex = ColorHex::fromString('#336699');
var_dump($int->getValue());

string(7) "#336699"
```

#### toCIELab(): ColorCIELab

Converts a color to a **CIELab**:

```php
$lab = ColorHex::fromString('#336699')->toCIELab();
```

#### toCMYK(): ColorCMYK

Converts a color to a **CMYK**:

```php
$cmyk = ColorHex::fromString('#336699')->toCMYK();
```

#### toHex(): ColorHex

Converts a color to a **Hex**:

```php
$hex = ColorRGBA::fromString('rgba(100,200,200,1.0)')->toHex();
```

#### toHSB(): ColorHSB

Converts a color to a **HSB/HSV**:

```php
$hsb = ColorHex::fromString('#336699')->toHSB();
```
#### toHSL(): ColorHSL

Converts a color to a **HSL**:

```php
$hsl = ColorHex::fromString('#336699')->toHSL();
```

#### toInt(): ColorInt

Converts a color to an **Int**:

```php
$int = ColorHex::fromString('#336699')->toInt();
```

#### toRGBA(): ColorRGBA

```php
$rgba = ColorInt::fromString('int(255)')->toRGBA();
```

#### toXYZ(): ColorXYZ

```php
$rgba = ColorCMYK::fromString('cmyk(0,0,0,0)')->toXYZ();
```

#### toComplementary(): Color

```php
$complementary = ColorRGBA::fromString('hsl(182,25,50)')->toComplementary();
```

#### toGreyscale(): Color

```php
$greyscale = ColorInt::fromString('int(4278255615)')->toGreyscale();
```

#### adjustBrightness(int $steps): Color

```php
$dark = ColorInt::fromString('int(4278255615)')->adjustBrightness(-10);
$light = ColorInt::fromString('int(4278255615)')->adjustBrightness(10);
```

#### distanceCIE76(Color $color): float

```php
$distance = ColorInt::fromString('int(4278255615)')->distanceCIE76(ColorInt::fromString('int(0)'));
```

## Testing

You can run the test suite via composer:

```bash
$ composer tests
```

> This Composer script runs the [PHPUnit](https://phpunit.de/) command with [PCOV](https://github.com/krakjoe/pcov) support in order to generate a Code Coverage report.

### Unit Tests

This library provides a [PHPUnit](https://phpunit.de/) testsuite with **1434 unit tests** and **2670 assertions**:

```bash
Time: 00:00.426, Memory: 24.00 MB

OK (1434 tests, 2670 assertions)
```

### Code Coverage

Here is the Code Coverage report summary:

```bash
Code Coverage Report:
  2022-07-22 06:32:15

 Summary:
  Classes: 100.00% (11/11)
  Methods: 100.00% (135/135)
  Lines:   100.00% (475/475)
```

> Full report will be generated in **./reports/coverage** folder.

## QA

### Static Analyzer

You can check this library with [PHPStan](https://phpstan.org/):

```bash
$ composer phpstan
```

This command generates the following report:

```bash
> vendor/bin/phpstan analyse --level 9 --memory-limit 1G --ansi ./src ./tests
 29/29 [▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓] 100%

 [OK] No errors
```

### PHP Parallel Lint

You can check this library with [PHP Parallel Lint](https://github.com/php-parallel-lint/PHP-Parallel-Lint):

```bash
$ composer linter
```

This command generates the following report:

```bash
PHP 8.1.8 | 10 parallel jobs
.............................                                29/29 (100 %)
Checked 29 files in 0.1 seconds
No syntax error found
```

## PHP Insights

You can check this library with [PHP Insights](https://phpinsights.com/):

```bash
$ composer phpinsights
```

This command generates the following summary:

```bash
> ./vendor/bin/phpinsights --fix

 16/16 [▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓] 100%

 ✨ Analysis Completed !

[2022-07-22 08:20:20] `/code`

                99.0%                  89.5%                  94.1%                  100 %
                Code                 Complexity            Architecture              Style

Score scale: ◼ 1-49 ◼ 50-79 ◼ 80-100

[CODE] 99 pts within 494 lines

Comments ....................................................... 5.1 %
Classes ....................................................... 85.6 %
Functions ...................................................... 0.0 %
Globally ....................................................... 9.3 %

[COMPLEXITY] 89.5 pts with average of 1.32 cyclomatic complexity

[ARCHITECTURE] 94.1 pts within 13 files

Classes ....................................................... 84.6 %
Interfaces ..................................................... 7.7 %
Globally ....................................................... 7.7 %
Traits ......................................................... 0.0 %

[MISC] 100 pts on coding style and 0 security issues encountered
```

## Security Vulnerabilities

Please review our security policy on how to report security vulnerabilities:

> **PLEASE DON'T DISCLOSE SECURITY-RELATED ISSUES PUBLICLY**

### Supported Versions

Only the latest major version receives security fixes.

### Reporting a Vulnerability

If you discover a security vulnerability within this project, please [open an issue here](https://github.com/alcidesrc/coloreeze/issues). All security vulnerabilities will be promptly addressed.

## License

The MIT License (MIT). Please see [License File](https://github.com/alcidesrc/coloreeze/blob/main/LICENSE) for more information.
