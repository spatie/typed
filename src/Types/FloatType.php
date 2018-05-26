<?php

declare(strict_types=1);

namespace Spatie\Typed\Types;

use Spatie\Typed\Nullable;
use Spatie\Typed\Type;

final class FloatType implements Type, Nullable
{
    use IsNullable;

    public function __invoke(float $value): float
    {
        return $value;
    }
}
