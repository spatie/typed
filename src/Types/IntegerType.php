<?php

namespace Spatie\Typed\Types;

final class IntegerType implements Type
{
    public function __invoke(int $value): int
    {
        return $value;
    }
}
