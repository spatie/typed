<?php

declare(strict_types=1);

namespace Spatie\Typed;

use Spatie\Typed\Types\NullableType;

interface Nullable extends Type
{
    public function nullable(): NullableType;
}
