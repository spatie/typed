<?php declare(strict_types=1);

namespace Typed\Types;

use Typed\Collection;

final class CollectionType implements Type
{
    public function __invoke(Collection $value): Collection
    {
        return $value;
    }
}
