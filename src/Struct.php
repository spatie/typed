<?php

declare(strict_types=1);

namespace Spatie\Typed;

use ArrayAccess;
use Spatie\Typed\Exceptions\WrongType;
use Spatie\Typed\Exceptions\UninitialisedError;

class Struct implements ArrayAccess
{
    use ValidatesType;

    /** @var array */
    private $types = [];

    /** @var array */
    private $values = [];

    public function __construct(array $types)
    {
        foreach ($types as $field => $type) {
            if (! $type instanceof Type) {
                $this->values[$field] = $type;

                $type = T::infer($type);
            }

            $this->types[$field] = $type;
        }
    }

    public function set(array $data): self
    {
        foreach ($this->types as $name => $type) {
            if (! array_key_exists($name, $data)) {
                $type = serialize($type);

                throw WrongType::withMessage("Missing field for this struct: {$name}:{$type}");
            }

            $data[$name] = $this->validateType($type, $data[$name]);
        }

        $this->values = $data;

        return $this;
    }

    public function offsetGet($offset)
    {
        if (! array_key_exists($offset, $this->values)) {
            throw UninitialisedError::forField($offset);
        }

        return $this->values[$offset];
    }

    public function offsetSet($offset, $value)
    {
        if ($offset === null) {
            throw WrongType::withMessage('No field specified');
        }

        $type = $this->types[$offset] ?? null;

        if (! $type) {
            throw WrongType::withMessage("No type was configured for this field {$offset}");
        }

        $this->values[$offset] = $this->validateType($type, $value);
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->values);
    }

    public function offsetUnset($offset)
    {
        throw WrongType::withMessage('Struct values cannot be unset');
    }

    public function toArray(): array
    {
        return $this->values;
    }

    public function __get($name)
    {
        return $this[$name];
    }

    public function __set($name, $value)
    {
        $this[$name] = $value;
    }
}
