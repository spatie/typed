<?php

namespace Spatie\Typed\Types;

use Spatie\Typed\Type;
use Spatie\Typed\NullableType;

final class IntegerType implements Type, NullableType
{
    use IsNullable;

    public function __invoke(int $value): int
    {
        return $value;
    }
}
