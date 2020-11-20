<?php

declare(strict_types=1);

namespace Spatie\Typed\Lists;

use Spatie\Typed\Collection;
use Spatie\Typed\Types\BooleanType;

final class BooleanList extends Collection
{
    public function __construct(array $data = [])
    {
        parent::__construct(new BooleanType());
        $this->set($data);
    }
}
