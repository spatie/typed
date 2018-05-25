<?php

declare(strict_types=1);

namespace Spatie\Typed\Types;

use Spatie\Typed\IsNullable;

final class CallableType implements Type
{
    use IsNullable;

    public function __invoke(callable $value): callable
    {
        return $value;
    }
}
