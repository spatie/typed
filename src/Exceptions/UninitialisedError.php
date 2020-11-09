<?php

namespace Spatie\Typed\Exceptions;

use TypeError;

class UninitialisedError extends TypeError
{
    public static function forField(string $name): self
    {
        return new self("Field {$name} was uninitialised.");
    }
}
