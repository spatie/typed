<?php

declare(strict_types=1);

namespace Spatie\Typed\Types;

use Spatie\Typed\IsNullable;

final class StringType implements Type
{
    use IsNullable;

    public function __invoke(string $value): string
    {
        return $value;
    }
}
