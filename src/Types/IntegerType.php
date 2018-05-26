<?php

namespace Spatie\Typed\Types;

use Spatie\Typed\Type;
use Spatie\Typed\Nullable;

final class IntegerType implements Type, Nullable
{
    use IsNullable;

    public function __invoke(int $value): int
    {
        return $value;
    }
}
