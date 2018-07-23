<?php

namespace Spatie\Typed\Excpetions;

use TypeError;

class UninitialisedError extends TypeError
{
    public static function forField(string $name): UninitialisedError
    {
        return new self("Field {$name} was uninitialised.");
    }
}
