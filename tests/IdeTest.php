<?php

declare(strict_types=1);

namespace Spatie\Typed\Tests;

use Spatie\Typed\Tests\Extra\Bar;
use Spatie\Typed\Tests\Extra\Foo;
use Spatie\Typed\Tests\Extra\FooBar;
use Spatie\Typed\Tests\Extra\Vector;
use Spatie\Typed\Tests\Extra\VectorList;

/**
 * This test case is used to test IDE auto completion, it doesn't actually assert anything useful.
 */
class IdeTest extends TestCase
{
    /** @test */
    public function collection_auto_completion()
    {
        $list = new VectorList([new Vector(1, 1, 2, 2)]);

        foreach ($list as $vector) {
            $vector->a[0];
        }

        $this->addToAssertionCount(1);
    }

    /** @test */
    public function struct_auto_completion()
    {
        $vector = new Vector(1, 1, 2, 2);

        $vector->a;

        $this->addToAssertionCount(1);
    }

    /** @test */
    public function tuple_auto_completion()
    {
        $fooBar = new FooBar(new Foo(), new Bar());

        $fooBar[0]->foo();
        $fooBar[1]->bar();

        $this->addToAssertionCount(1);
    }
}
