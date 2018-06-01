<?php

declare(strict_types=1);

namespace Spatie\Typed\Tests\Extra;

use Spatie\Typed\Tuple;
use Spatie\Typed\Types\IntegerType;

class Point extends Tuple
{
    public function __construct(int $x, int $y)
    {
        parent::__construct(new IntegerType(), new IntegerType());

        $this[0] = $x;
        $this[1] = $y;
    }

    /**
     * @param mixed $offset
     *
     * @return int
     */
    public function offsetGet($offset)
    {
        return parent::offsetGet($offset);
    }

    public function getX(): int
    {
        return $this[0];
    }

    public function getY(): int
    {
        return $this[1];
    }
}
