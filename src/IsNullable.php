<?php

declare(strict_types=1);

namespace Spatie\Typed;

use Spatie\Typed\Types\NullableType;

trait IsNullable
{
    public function nullable(): NullableType
    {
        return new NullableType($this);
    }
}
