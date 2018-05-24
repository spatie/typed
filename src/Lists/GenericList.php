<?php declare(strict_types=1);

namespace Typed\Lists;

use Typed\Collection;
use Typed\T;

final class GenericList extends Collection
{
    public function __construct(string $type, array $data = [])
    {
        parent::__construct(T::generic($type), $data);
    }
}
