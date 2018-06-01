<?php

declare(strict_types=1);

namespace Spatie\Typed\Types;

use Spatie\Typed\Type;

final class ArrayType implements Type
{
    use Nullable;

    public function validate($value): array
    {
        return $value;
    }

    public function __toString(): string
    {
        return 'array';
    }
}
