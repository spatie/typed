<?php

declare(strict_types=1);

namespace Spatie\Typed;

use Iterator;
use Countable;
use ArrayAccess;

class Collection implements ArrayAccess, Iterator, Countable
{
    use ValidatesType;

    /** @var \Spatie\Typed\Type */
    private $type;

    /** @var array */
    protected $data = [];

    /** @var int */
    private $position = 0;

    /**
     * @var \Spatie\Typed\Type|array $type
     */
    public function __construct($type)
    {
        if ($type instanceof Type) {
            $this->type = $type;

            return;
        }

        $firstValue = reset($type);

        $this->type = T::infer($firstValue);

        $this->set($type);
    }

    public function set(array $data): Collection
    {
        foreach ($data as $item) {
            $this[] = $item;
        }

        return $this;
    }

    public function current()
    {
        return $this->data[$this->position];
    }

    public function offsetGet($offset)
    {
        return isset($this->data[$offset]) ? $this->data[$offset] : null;
    }

    public function offsetSet($offset, $value)
    {
        $value = $this->validateType($this->type, $value);

        if (is_null($offset)) {
            $this->data[] = $value;
        } else {
            $this->data[$offset] = $value;
        }
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->data);
    }

    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

    public function next()
    {
        $this->position++;
    }

    public function key()
    {
        return $this->position;
    }

    public function valid()
    {
        return array_key_exists($this->position, $this->data);
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function toArray(): array
    {
        return $this->data;
    }

    public function count(): int
    {
        return count($this->data);
    }
}
