<?php

namespace Spatie\Typed\Types;

interface Type
{
    /**
     * Creates nullable variant of this type.
     *
     * @return NullableType
     */
    public function nullable(): NullableType;
}
