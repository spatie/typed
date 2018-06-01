<?php

declare(strict_types=1);

namespace Spatie\Typed\Tests;

use Spatie\Typed\Collection;
use Spatie\Typed\T;
use Spatie\Typed\Tests\Extra\Post;
use Spatie\Typed\Tests\Extra\Wrong;
use TypeError;

class CompoundTypeTest extends TestCase
{
    /** @test */
    public function types_can_be_combined()
    {
        $list = new Collection(T::compound(T::int(), T::float()));

        $list[] = 1;
        $list[] = 1.1;

        $this->assertTrue(1 === $list[0]);
        $this->assertTrue(1.1 === $list[1]);
    }

    /** @test */
    public function compound_with_generics()
    {
        $list = new Collection(T::compound(T::generic(Post::class)));

        $list[] = new Post();

        $this->expectException(TypeError::class);

        $list[] = new Wrong();
    }

    /** @test */
    public function nullable_compound()
    {
        $list = new Collection(T::compound(T::int(), T::float())->nullable());

        $list[] = 1;

        $list[] = null;

        $list[] = 1.1;

        $this->expectException(TypeError::class);

        $list[] = new Wrong();
    }

    /** @test */
    public function nullable_child_compound()
    {
        $list = new Collection(T::compound(T::int()->nullable(), T::float()));

        $list[] = 1;

        $list[] = null;

        $list[] = 1.1;

        $this->expectException(TypeError::class);

        $list[] = new Wrong();
    }

    /** @test */
    public function wrong_types_throws_an_error()
    {
        $this->expectException(TypeError::class);

        $list = new Collection(T::compound(T::int(), T::float()));

        $list[] = 'abc';
    }
}
