<?php

declare(strict_types=1);

namespace Spatie\Typed;

use Iterator;

final class TupleIterator implements Iterator
{
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
}
