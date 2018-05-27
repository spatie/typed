<?php

declare(strict_types=1);

namespace Spatie\Typed\Types;

use Spatie\Typed\NullableType;

final class StringType implements NullableType
{
    use IsNullable;

    public function __invoke(string $value): string
    {
        return $value;
    }
}
