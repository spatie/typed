<?php

declare(strict_types=1);

namespace Spatie\Typed\Types;

use Spatie\Typed\Collection;
use Spatie\Typed\NullableType;

final class CollectionType implements NullableType
{
    use IsNullable;

    public function __invoke(Collection $value): Collection
    {
        return $value;
    }
}
