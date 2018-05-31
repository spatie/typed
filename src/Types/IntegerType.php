<?php

namespace Spatie\Typed\Types;

use Spatie\Typed\Type;

final class IntegerType implements Type
{
    use Nullable;

    public function __invoke(int $value): int
    {
        return $value;
    }
}
