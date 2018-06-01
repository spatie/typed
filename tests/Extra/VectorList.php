<?php

declare(strict_types=1);

namespace Spatie\Typed\Tests\Extra;

use Spatie\Typed\Collection;
use Spatie\Typed\Types\GenericType;

class VectorList extends Collection
{
    public function __construct(array $vectors)
    {
        parent::__construct(new GenericType(Vector::class), $vectors);
    }

    public function current(): Vector
    {
        return parent::current();
    }
}
