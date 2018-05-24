<?php

namespace Typed\Types;

final class IntegerType implements Type
{
    public function __invoke(int $value): int
    {
        return $value;
    }
}
