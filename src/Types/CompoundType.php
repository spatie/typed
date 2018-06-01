<?php

declare(strict_types=1);

namespace Spatie\Typed\Types;

use Spatie\Typed\Type;
use Spatie\Typed\WrongType;
use TypeError;

class CompoundType implements Type
{
    use Nullable;

    /** @var \Spatie\Typed\Type[] */
    private $types;

    public function __construct(Type ...$types)
    {
        $this->types = $types;
    }

    public function __invoke($value)
    {
        $initialValue = $this->copyValue($value);

        foreach ($this->types as $type) {
            $currentValue = $this->copyValue($initialValue);

            try {
                $currentValue = ($type)($currentValue);
            } catch (TypeError $typeError) {
                continue;
            }

            if (! $this->sameType($initialValue, $currentValue, $type)) {
                continue;
            }

            return $initialValue;
        }

        throw WrongType::withMessage("Type must be either one of");
    }

    private function copyValue($value)
    {
        if (is_object($value)) {
            return clone $value;
        }

        return $value;
    }

    private function sameType($currentValue, $initialValue, Type $type): bool
    {
        if ($type instanceof NullType && $initialValue === null) {
            return true;
        }

        if (is_scalar($initialValue) && $currentValue === $initialValue) {
            return true;
        }

        if (is_object($initialValue) && get_class($initialValue) === get_class($currentValue)) {
            return true;
        }

        return false;
    }
}
