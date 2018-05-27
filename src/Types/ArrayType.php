<?php

declare(strict_types=1);

namespace Spatie\Typed\Types;

use Spatie\Typed\Type;
use Spatie\Typed\NullableType;

final class ArrayType implements Type, NullableType
{
    use IsNullable;

    public function __invoke(array $value): array
    {
        return $value;
    }
}
