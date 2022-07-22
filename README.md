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

> This Composer script runs the PHPUnit command with PCOV support in order to generate a Code Coverage report.

### Unit Tests

This library provides a PHPUnit testsuite with **1434 unit tests** and **2670 assertions**:

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
