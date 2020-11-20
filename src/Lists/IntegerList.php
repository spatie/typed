<?php

declare(strict_types=1);

namespace Spatie\Typed\Lists;

use Spatie\Typed\Collection;
use Spatie\Typed\Types\IntegerType;

final class IntegerList extends Collection
{
    public function __construct(array $data = [])
    {
        parent::__construct(new IntegerType());
        $this->set($data);
    }
}
