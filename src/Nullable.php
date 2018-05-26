<?php

declare(sctrict_types=1);

namespace Spatie\Typed;

use Spatie\Typed\Types\NullableType;

interface Nullable
{
    public function nullable(): NullableType;
}
