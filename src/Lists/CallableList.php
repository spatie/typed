<?php

declare(strict_types=1);

namespace Spatie\Typed\Lists;

use Spatie\Typed\Collection;
use Spatie\Typed\Types\CallableType;

final class CallableList extends Collection
{
    public function __construct(array $data = [])
    {
        parent::__construct(new CallableType());
        $this->set($data);
    }
}
