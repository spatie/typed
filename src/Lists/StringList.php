<?php declare(strict_types=1);

namespace Typed\Lists;

use Typed\Collection;
use Typed\Types\StringType;

final class StringList extends Collection
{
    public function __construct(array $data = [])
    {
        parent::__construct(StringType::class, $data);
    }
}
