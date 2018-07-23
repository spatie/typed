<?php

namespace Spatie\Typed\Excpetions;

use TypeError;

class InferredTypeError extends TypeError
{
    public static function cannotInferType(string $name): self
    {
        return new self("Cannot infer type {$name}.");
    }
}
