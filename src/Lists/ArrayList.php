<?php declare(strict_types=1);

namespace Typed\Lists;

use Typed\Collection;
use Typed\Types\ArrayType;

final class ArrayList extends Collection
{
    public function __construct(array $data = [])
    {
        parent::__construct(ArrayType::class, $data);
    }
}
