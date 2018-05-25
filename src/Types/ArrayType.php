<?php

declare(strict_types=1);

namespace Spatie\Typed\Types;

use Spatie\Typed\IsNullable;

final class ArrayType implements Type
{
    use IsNullable;

    public function __invoke(array $value): array
    {
        return $value;
    }
}
