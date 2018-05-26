<?php

namespace Spatie\Typed\Tests;

use TypeError;
use Spatie\Typed\T;
use Spatie\Typed\Collection;
use Spatie\Typed\Lists\IntegerList;

class CollectionTest extends TestCase
{
    /** @test */
    public function test_collection()
    {
        $list = new IntegerList();

        $list[] = 1;

        foreach ($list as $i) {
            $this->assertEquals(1, $i);
        }

        $this->assertEquals(1, $list[0]);
    }

    /** @test */
    public function test_wrong_offset_set()
    {
        $this->expectException(TypeError::class);

        $list = new IntegerList();

        $list[] = 'a';
    }

    /** @test */
    public function collection_with_generics()
    {
        $list = new Collection(T::generic(Post::class));

        $list[] = new Post();

        $this->assertInstanceOf(Post::class, $list[0]);

        $this->expectException(TypeError::class);

        $list[] = new Wrong();
    }

    /** @test */
    public function collection_of_collection()
    {
        $listOfLists = new Collection(T::generic(Collection::class));

        $listOfLists[] = new Collection(T::string(), ['a', 'b']);

        $listOfLists[] = new Collection(T::int(), [1, 2]);

        $listOfLists[0][0] = 'c';

        $this->expectException(TypeError::class);

        $listOfLists[0][0] = new Wrong();
    }

    /** @test */
    public function test_nullable_collection()
    {
        $list = new Collection(T::nullable(T::int()));

        $list[] = null;
        $list[] = null;

        foreach ($list as $i) {
            $this->assertEquals(null, $i);
        }

        $list[] = 1;

        $this->assertEquals(null, $list[0]);
        $this->assertEquals(null, $list[1]);
        $this->assertEquals(1, $list[2]);
    }
}
