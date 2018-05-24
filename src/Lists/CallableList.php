<?php declare(strict_types=1);

namespace Typed\Lists;

use Typed\Collection;
use Typed\Types\CallableType;

final class CallableList extends Collection
{
    public function __construct(array $data = [])
    {
        parent::__construct(CallableType::class, $data);
    }
}
