<?php

namespace Typed;

use ArrayAccess;
use TypeError;

class Struct implements ArrayAccess
{
    use ValidatesType;

    /** @var array */
    private $definition;

    /** @var array */
    private $data;

    public function __construct(array $definition)
    {
        $this->definition = $definition;

        $this->data = [];
    }

    public function set(array $data): self
    {
        foreach ($this->definition as $name => $type) {
            if (! isset($data[$name])) {
                throw WrongType::fromMessage("Missing field for this struct: {$name}:{$type}");
            }

            $data[$name] = $this->validateType($type, $data[$name]);
        }

        $this->data = $data;

        return $this;
    }

    public function offsetGet($offset)
    {
        return isset($this->data[$offset]) ? $this->data[$offset] : null;
    }

    public function offsetSet($offset, $value)
    {
        if ($offset === null) {
            throw WrongType::fromMessage('No field specified');
        }

        $type = $this->definition[$offset] ?? null;

        if (! $type) {
            throw WrongType::fromMessage("No type was configured for this field {$offset}");
        }

        $this->data[$offset] = $this->validateType($type, $value);
    }

    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    public function offsetUnset($offset)
    {
        throw WrongType::fromMessage('Struct values cannot be unset');
    }

    public function toArray(): array
    {
        return $this->data;
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
