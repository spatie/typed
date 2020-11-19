<?php

declare(strict_types=1);

namespace Spatie\Typed\Types;

use TypeError;
use Spatie\Typed\Type;
use Spatie\Typed\ValidatesType;
use Spatie\Typed\Exceptions\WrongType;

class UnionType implements Type
{
    use Nullable, ValidatesType;

    /** @var \Spatie\Typed\Type[] */
    private $types;

    public function __construct(Type ...$types)
    {
        $this->types = $types;
    }

    public function validate($value)
    {
        $initialValue = $this->copyValue($value);

        foreach ($this->types as $type) {
            $currentValue = $this->copyValue($initialValue);

            try {
                $currentValue = $type->validate($currentValue);
            } catch (TypeError $typeError) {
                continue;
            }

            if (! $this->sameType($initialValue, $currentValue, $type)) {
                continue;
            }

            return $initialValue;
        }

        throw WrongType::withMessage("Type must be either one of: {$this->getAvailableTypesString()}");
    }

    public function __toString(): string
    {
        return 'union';
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

    private function getAvailableTypesString(): string
    {
        return implode(', ', array_map(function (Type $type) {
            return (string) $type;
        }, $this->types));
    }
}
