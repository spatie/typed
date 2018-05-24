<?php declare(strict_types=1);

namespace Typed\Lists;

use Typed\Collection;
use Typed\Types\IntegerType;

final class IntegerList extends Collection
{
    public function __construct(array $data = [])
    {
        parent::__construct(IntegerType::class, $data);
    }
}
