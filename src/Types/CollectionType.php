<?php

declare(strict_types=1);

namespace Spatie\Typed\Types;

use Spatie\Typed\Collection;
use Spatie\Typed\Nullable;
use Spatie\Typed\Type;

final class CollectionType implements Type, Nullable
{
    use IsNullable;

    public function __invoke(Collection $value): Collection
    {
        return $value;
    }
}
