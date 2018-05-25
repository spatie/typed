<?php declare(strict_types=1);

namespace Spatie\Typed\Types;

final class NullableType implements Type
{

    /**
     * @var Type|callable
     */
    private $type;

    public function __construct(Type $type)
    {
        $this->type = $type;
    }

    public function __invoke($value)
    {
        if ($value === null) {
            return null;
        }

        return ($this->type)($value);
    }
}
