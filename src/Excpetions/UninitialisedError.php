<?php

namespace Spatie\Typed\Excpetions;

use TypeError;

class UninitialisedError extends TypeError
{
    public static function value(string $name): UninitialisedError
    {
        return new self("Property {$name} was uninitialised.");
    }
}
