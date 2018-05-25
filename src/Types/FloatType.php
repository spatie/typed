<?php declare(strict_types=1);

namespace Spatie\Typed\Types;

final class FloatType implements Type
{
    public function __invoke(float $value): float
    {
        return $value;
    }
}
