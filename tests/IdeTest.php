<?php

declare(strict_types=1);

namespace Spatie\Typed\Tests;

use Spatie\Typed\Tests\Extra\Bar;
use Spatie\Typed\Tests\Extra\Foo;
use Spatie\Typed\Tests\Extra\FooBar;
use Spatie\Typed\Tests\Extra\Vector;
use Spatie\Typed\Tests\Extra\VectorList;

class IdeTest extends TestCase
{
    /** @test */
    public function a()
    {
        $list = new VectorList([new Vector(1, 1, 2, 2)]);

        foreach ($list as $vector) {
            $vector->a[0];
        }

        $this->assertTrue(true);
    }

    /** @test */
    public function b()
    {
        $fooBar = new FooBar(new Foo(), new Bar());

        $fooBar[0]->foo();
        $fooBar[1]->bar();

        $this->assertTrue(true);
    }
}
