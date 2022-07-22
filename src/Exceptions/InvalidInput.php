<?php

declare(strict_types=1);

namespace Fonil\Coloreeze\Exceptions;

use Exception;

final class InvalidInput extends Exception
{
    public static function notInRange(int|float $input, int|float $min, int|float $max, string $context): self
    {
        return new self("Invalid input [ {$input} ] related with [ {$context} ]: Not in range ({$min}, {$max})");
    }

    public static function notMatchingAnyColor(string $input): self
    {
        return new self("Color string [ {$input} ] does not match any of the available colors.");
    }

    public static function wrongFormat(string $input, string $context): self
    {
        return new self("Invalid input [ {$input} ] related with [ {$context} ]: Wrong format.");
    }
}
