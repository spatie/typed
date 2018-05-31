<?php

declare(strict_types=1);

namespace Spatie\Typed\Types;

use Spatie\Typed\Type;

final class StringType implements Type
{
    use Nullable;

    public function __invoke(string $value): string
    {
        return $value;
    }
}
