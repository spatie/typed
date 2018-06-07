<?php

declare(strict_types=1);

namespace Spatie\Typed\Tests\Extra;

use Spatie\Typed\Collection;
use Spatie\Typed\Types\GenericType;

class LineCollection extends Collection
{
    public function __construct(array $lines)
    {
        parent::__construct(new GenericType(Line::class), $lines);
    }

    public function current(): Line
    {
        return parent::current();
    }
}
