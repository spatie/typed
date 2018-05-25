<?php declare(strict_types=1);

namespace Spatie\Typed\Types;

final class BooleanType implements Type
{
    public function __invoke(bool $value): bool
    {
        return $value;
    }
}
