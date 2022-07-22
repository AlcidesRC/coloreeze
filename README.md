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
$ composer require fonil/coloreeze
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

## Changelog

Please visit [CHANGELOG](https://github.com/fonil/coloreeze/blob/master/CHANGELOG.md) for further information related with latest changes.

## Security Vulnerabilities

Please review our security policy on how to report security vulnerabilities:

> **PLEASE DON'T DISCLOSE SECURITY-RELATED ISSUES PUBLICLY**

### Supported Versions

Only the latest major version receives security fixes.

### Reporting a Vulnerability

If you discover a security vulnerability within this project, please [open an issue here](https://github.com/fonil/coloreeze/issues). All security vulnerabilities will be promptly addressed.

## License

The MIT License (MIT). Please see [License File](https://github.com/fonil/coloreeze/blob/main/LICENSE) for more information.
