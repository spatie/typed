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

    /** @var @var array */
    private $data;

    public function __construct(Type ...$types)
    {
        $this->types = $types;
    }

    public function set(array $data): self
    {
        $iterator = $this->createIterator($data);

        foreach ($iterator as $key => ['type' => $type, 'value' => $value]) {
            $data[$key] = $this->validateType($type, $value);
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
        if ($offset === null || ! is_numeric($offset)) {
            throw WrongType::fromMessage('You must specify a numeric offset');
        }

        $type = $this->types[$offset] ?? null;

        if (! $type) {
            throw WrongType::fromMessage("No type was configured for this tuple at offset {$offset}");
        }

        $this->data[$offset] = $this->validateType($type, $value);
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->data);
    }

    public function offsetUnset($offset)
    {
        throw WrongType::fromMessage('Tuple values cannot be unset');
    }

    public function toArray(): array
    {
        return $this->data;
    }

    private function createIterator(array $data): Iterator
    {
        return new class($this->types, $data) implements Iterator {
            /** @var array */
            private $types;

            /** @var array */
            private $data;

            /** @var int */
            private $position;

            public function __construct(array $types, array $data)
            {
                $typeCount = count($types);

                $dataCount = count($data);

                if ($typeCount !== $dataCount) {
                    throw WrongType::fromMessage("Tuple count mismatch, excpected exactly {$typeCount} elements, and got {$dataCount}");
                }

                $this->types = $types;
                $this->data = $data;
                $this->position = 0;
            }

            public function current(): array
            {
                return ['type' => current($this->types), 'value' => current($this->data)];
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
                return isset($this->types[$this->position]) && array_key_exists($this->position, $this->data);
            }

            public function rewind(): void
            {
                $this->position = 0;
            }
        };
    }
}
