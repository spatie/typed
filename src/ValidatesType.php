<?php

namespace Typed;

use TypeError;

trait ValidatesType
{
    private function validateType($type, $value)
    {
        $type = $this->resolveType($type);

        try {
            $value = call_user_func($type, $value);
        } catch (TypeError $typeError) {
            throw WrongType::wrap($typeError);
        }

        return $value;
    }

    private function resolveType($type)
    {
        if (is_string($type) && class_exists($type)) {
            $type = new $type;
        }

        if (! is_callable($type)) {
            throw WrongType::fromMessage('Generic types must be callable');
        }

        return $type;
    }
}
