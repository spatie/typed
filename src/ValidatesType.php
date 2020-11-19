<?php

declare(strict_types=1);

namespace Spatie\Typed;

use TypeError;
use Spatie\Typed\Exceptions\WrongType;

trait ValidatesType
{
    private function validateType(Type $type, $value)
    {
        try {
            $value = $type->validate($value);
        } catch (TypeError $typeError) {
            throw WrongType::wrap($typeError);
        }

        return $value;
    }
}
