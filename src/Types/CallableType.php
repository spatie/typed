<?php

declare(strict_types=1);

namespace Spatie\Typed\Types;

use Spatie\Typed\Nullable;
use Spatie\Typed\Type;

final class CallableType implements Type, Nullable
{
    use IsNullable;

    public function __invoke(callable $value): callable
    {
        return $value;
    }
}
