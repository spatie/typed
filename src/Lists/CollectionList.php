<?php

declare(strict_types=1);

namespace Spatie\Typed\Lists;

use Spatie\Typed\Collection;
use Spatie\Typed\Types\CollectionType;

final class CollectionList extends Collection
{
    public function __construct(array $data = [])
    {
        parent::__construct(new CollectionType());
        $this->set($data);
    }
}
