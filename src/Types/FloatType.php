<?php

declare(strict_types=1);

namespace Spatie\Typed\Types;

use Spatie\Typed\NullableType;

final class FloatType implements NullableType
{
    use IsNullable;

    public function __invoke(float $value): float
    {
        return $value;
    }
}
