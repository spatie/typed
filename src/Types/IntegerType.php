<?php

namespace Spatie\Typed\Types;

use Spatie\Typed\IsNullable;

final class IntegerType implements Type
{
    use IsNullable;

    public function __invoke(int $value): int
    {
        return $value;
    }
}
