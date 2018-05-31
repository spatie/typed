<?php

declare(strict_types=1);

namespace Spatie\Typed;

use TypeError;

trait ValidatesType
{
    private function validateType(Type $type, $value)
    {
        try {
            $value = ($type)($value);
        } catch (TypeError $typeError) {
            throw WrongType::wrap($typeError);
        }

        return $value;
    }
}
