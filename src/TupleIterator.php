<?php declare(strict_types=1);

namespace Typed;

use TypeError;

final class TupleIterator implements \Iterator
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

    public function current(): TypedValue
    {
        return new TypedValue(current($this->types), current($this->data));
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function key(): int
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return isset(
            $this->types[$this->position],
            $this->data[$this->position]
        );
    }

    public function rewind(): void
    {
        $this->position = 0;
    }
}
