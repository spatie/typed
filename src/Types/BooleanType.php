<?php

declare(strict_types=1);

namespace Spatie\Typed\Types;

use Spatie\Typed\Type;
use Spatie\Typed\NullableType;

final class BooleanType implements Type, NullableType
{
    use IsNullable;

    public function __invoke(bool $value): bool
    {
        return $value;
    }
}
