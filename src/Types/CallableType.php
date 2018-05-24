<?php declare(strict_types=1);

namespace Typed\Types;

final class CallableType implements Type
{
    public function __invoke(callable $value): callable
    {
        return $value;
    }
}
