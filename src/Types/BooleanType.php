<?php

declare(strict_types=1);

namespace Spatie\Typed\Types;

use Spatie\Typed\IsNullable;

final class BooleanType implements Type
{
    use IsNullable;

    public function __invoke(bool $value): bool
    {
        return $value;
    }
}
