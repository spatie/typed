<?php

declare(strict_types=1);

namespace Spatie\Typed\Types;

use Spatie\Typed\Nullable;
use Spatie\Typed\Type;

final class BooleanType implements Type, Nullable
{
    use IsNullable;

    public function __invoke(bool $value): bool
    {
        return $value;
    }
}
