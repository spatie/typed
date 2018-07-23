<?php

declare(strict_types=1);

namespace Spatie\Typed;

use Iterator;
use ArrayAccess;

class Tuple implements ArrayAccess
{
    use ValidatesType;

    /** @var \Spatie\Typed\Type[] */
    private $types;

    /** @var array */
    private $data;

    public function __construct(...$types)
    {
        $firstValue = reset($types);

        if ($firstValue instanceof Type) {
            $this->types = $types;

            return;
        }

        foreach ($types as $value) {
            $this->types[] = T::infer($value);
        }

        $this->set(...$types);
    }

    public function set(...$values): self
    {
        $iterator = $this->createIterator($values);

        foreach ($iterator as $key => ['type' => $type, 'value' => $value]) {
            $values[$key] = $this->validateType($type, $value);
        }

        $this->data = $values;

        return $this;
    }

    public function offsetGet($offset)
    {
        return isset($this->data[$offset]) ? $this->data[$offset] : null;
    }

    public function offsetSet($offset, $value)
    {
        if ($offset === null || ! is_numeric($offset)) {
            throw WrongType::withMessage('You must specify a numeric offset');
        }

        $type = $this->types[$offset] ?? null;

        if (! $type) {
            throw WrongType::withMessage("No type was configured for this tuple at offset {$offset}");
        }

        $this->data[$offset] = $this->validateType($type, $value);
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->data);
    }

    public function offsetUnset($offset)
    {
        throw WrongType::withMessage('Tuple values cannot be unset');
    }

    public function toArray(): array
    {
        return $this->data;
    }

    private function createIterator(array $values): Iterator
    {
        return new class($this->types, $values) implements Iterator {
            /** @var array */
            private $types;

            /** @var array */
            private $values;

            /** @var int */
            private $position;

            public function __construct(array $types, array $values)
            {
                $typeCount = count($types);

                $dataCount = count($values);

                if ($typeCount !== $dataCount) {
                    throw WrongType::withMessage("Tuple count mismatch, expected exactly {$typeCount} elements, and got {$dataCount}");
                }

                $this->types = $types;
                $this->values = $values;
                $this->position = 0;
            }

            public function current(): array
            {
                return ['type' => $this->types[$this->position], 'value' => $this->values[$this->position]];
            }

            public function next(): void
            {
                $this->position++;
            }

            public function key(): int
            {
                return $this->position;
            }

            public function valid(): bool
            {
                return isset($this->types[$this->position]) && array_key_exists($this->position, $this->values);
            }

            public function rewind(): void
            {
                $this->position = 0;
            }
        };
    }
}
