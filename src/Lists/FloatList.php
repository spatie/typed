<?php

declare(strict_types=1);

namespace Spatie\Typed\Lists;

use Spatie\Typed\Collection;
use Spatie\Typed\Types\FloatType;

final class FloatList extends Collection
{
    public function __construct(array $data = [])
    {
        parent::__construct(new FloatType());
        $this->set($data);
    }
}
