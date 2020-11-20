<?php

declare(strict_types=1);

namespace Spatie\Typed\Lists;

use Spatie\Typed\Collection;
use Spatie\Typed\Types\ArrayType;

final class ArrayList extends Collection
{
    public function __construct(array $data = [])
    {
        parent::__construct(new ArrayType());
        $this->set($data);
    }
}
