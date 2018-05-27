<?php

declare(strict_types=1);

namespace Spatie\Typed\Types;

use Spatie\Typed\NullableType;
use Spatie\Typed\Type;

final class NullType implements NullableType
{
    /** @var \Spatie\Typed\Type */
    private $type;

    public function __construct(NullableType $type)
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
