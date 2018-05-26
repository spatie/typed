<?php

declare(strict_types=1);

namespace Spatie\Typed\Types;

trait IsNullable
{
    public function nullable(): NullableType
    {
        return new NullableType($this);
    }
}
