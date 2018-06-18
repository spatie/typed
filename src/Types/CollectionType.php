<?php

declare(strict_types=1);

namespace Spatie\Typed\Types;

use Spatie\Typed\Type;
use Spatie\Typed\Collection;

final class CollectionType implements Type
{
    use Nullable;

    public function validate($value): Collection
    {
        return $value;
    }
}
