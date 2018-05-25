<?php declare(strict_types=1);

namespace Spatie\Typed\Lists;

use Spatie\Typed\Collection;
use Spatie\Typed\T;

final class GenericList extends Collection
{
    public function __construct(string $type, array $data = [])
    {
        parent::__construct(T::generic($type), $data);
    }
}
