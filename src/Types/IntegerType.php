<?php

namespace Spatie\Typed\Types;

use Spatie\Typed\NullableType;

final class IntegerType implements NullableType
{
    use IsNullable;

    public function __invoke(int $value): int
    {
        return $value;
    }
}
