<?php

declare(strict_types=1);

namespace Spatie\Typed\Types;

use Spatie\Typed\Type;

final class FloatType implements Type
{
    use Nullable;

    public function validate($value): float
    {
        return $value;
    }
}
