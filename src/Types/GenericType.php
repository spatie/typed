<?php

namespace Spatie\Typed\Types;

use Spatie\Typed\Type;
use Spatie\Typed\WrongType;

final class GenericType implements Type
{
    use Nullable;

    /** @var string */
    private $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function __invoke($value)
    {
        if (
            ! $value instanceof $this->type
        ) {
            throw WrongType::withMessage("must be of type {$this->type}");
        }

        return $value;
    }
}
