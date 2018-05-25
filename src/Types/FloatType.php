<?php

declare(strict_types=1);

namespace Spatie\Typed\Types;

use Spatie\Typed\IsNullable;

final class FloatType implements Type
{
    use IsNullable;

    public function __invoke(float $value): float
    {
        return $value;
    }
}
