<?php

declare(strict_types=1);

namespace Spatie\Typed\Types;

use Spatie\Typed\Type;

final class BooleanType implements Type
{
    use Nullable;

    public function validate($value): bool
    {
        return $value;
    }

    public function __toString(): string
    {
        return 'boolean';
    }
}
