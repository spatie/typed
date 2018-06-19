<?php

declare(strict_types=1);

namespace Spatie\Typed;

use ArrayAccess;

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
            if (! array_key_exists($name, $data)) {
                $type = serialize($type);

                throw WrongType::withMessage("Missing field for this struct: {$name}:{$type}");
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
            throw WrongType::withMessage('No field specified');
        }

        $type = $this->definition[$offset] ?? null;

        if (! $type) {
            throw WrongType::withMessage("No type was configured for this field {$offset}");
        }

        $this->data[$offset] = $this->validateType($type, $value);
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->data);
    }

    public function offsetUnset($offset)
    {
        throw WrongType::withMessage('Struct values cannot be unset');
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
