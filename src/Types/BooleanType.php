<?php

declare(strict_types=1);

namespace Spatie\Typed\Types;

use Spatie\Typed\Type;
use Spatie\Typed\Nullable;

final class BooleanType implements Type, Nullable
{
    use IsNullable;

    public function __invoke(bool $value): bool
    {
        return $value;
    }
}
