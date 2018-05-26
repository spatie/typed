<?php

declare(strict_types=1);

namespace Spatie\Typed\Types;

use Spatie\Typed\Nullable;
use Spatie\Typed\Type;

final class StringType implements Type, Nullable
{
    use IsNullable;

    public function __invoke(string $value): string
    {
        return $value;
    }
}
