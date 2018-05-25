<?php

declare(strict_types=1);

namespace Spatie\Typed\Types;

final class StringType implements Type
{
    public function __invoke(string $value): string
    {
        return $value;
    }
}
