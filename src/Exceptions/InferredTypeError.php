<?php

namespace Spatie\Typed\Exceptions;

use TypeError;

class InferredTypeError extends TypeError
{
    public static function cannotInferType(string $name): self
    {
        return new self("Cannot infer type {$name}.");
    }
}
