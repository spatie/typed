<?php

declare(strict_types=1);

namespace Spatie\Typed\Lists;

use Spatie\Typed\Collection;
use Spatie\Typed\Types\StringType;

final class StringList extends Collection
{
    public function __construct(array $data = [])
    {
        parent::__construct(new StringType());
        $this->set($data);
    }
}
