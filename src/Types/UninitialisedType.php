<?php

namespace Spatie\Typed\Types;

use Spatie\Typed\Type;

class UninitialisedType implements Type
{
    use Nullable;

    public function validate($value)
    {
        return $value;
    }
}
