<?php

declare(strict_types=1);

namespace Spatie\Typed\Types;

use Spatie\Typed\Type;

final class NullType implements Type
{
    /** @var \Spatie\Typed\Type */
    private $type;

    public function __construct(Type $type)
    {
        $this->type = $type;
    }

    public function __invoke($value)
    {
        if ($value === null) {
            return;
        }

        return ($this->type)($value);
    }

    public function getType(): Type
    {
        return $this->type;
    }

    public function nullable(): self
    {
        return $this;
    }
}
