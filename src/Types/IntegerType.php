<?php

namespace Spatie\Typed\Types;

use Spatie\Typed\Nullable;
use Spatie\Typed\Type;

final class IntegerType implements Type, Nullable
{
    use IsNullable;

    public function __invoke(int $value): int
    {
        return $value;
    }
}
