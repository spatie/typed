<?php

namespace Spatie\Typed\Tests\Extra;

use Spatie\Typed\Tuple;
use Spatie\Typed\Types\GenericType;

class FooBar extends Tuple
{
    public function __construct(Foo $foo, Bar $bar)
    {
        parent::__construct(new GenericType(Foo::class), new GenericType(Bar::class));

        $this[0] = $foo;
        $this[1] = $bar;
    }

    /**
     * @param mixed $offset
     *
     * @return \Spatie\Typed\Tests\Extra\Foo|\Spatie\Typed\Tests\Extra\Bar
     */
    public function offsetGet($offset)
    {
        return parent::offsetGet($offset);
    }
}
