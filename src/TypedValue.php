<?php declare(strict_types=1);

namespace Typed;

use Typed\Types\Type;

final class TypedValue
{
    /** @var \Typed\Types\Type */
    private $type;

    /** @var mixed */
    private $value;

    public function __construct(Type $type, $value)
    {
        $this->type = $type;

        $this->value = $value;
    }

    public function type(): Type
    {
        return $this->type;
    }

    public function value()
    {
        return $this->value;
    }
}
