<?php declare(strict_types=1);

namespace Typed\Lists;

use Typed\Collection;
use Typed\Types\BooleanType;

final class BooleanList extends Collection
{
    public function __construct(array $data = [])
    {
        parent::__construct(BooleanType::class, $data);
    }
}
