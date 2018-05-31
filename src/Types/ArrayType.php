<?php

declare(strict_types=1);

namespace Spatie\Typed\Types;

use Spatie\Typed\Type;

final class ArrayType implements Type
{
    use Nullable;

    public function __invoke(array $value): array
    {
        return $value;
    }
}
