<?php

declare(strict_types=1);

namespace Spatie\Typed\Tests;

use Spatie\Typed\T;
use Spatie\Typed\Tuple;
use Spatie\Typed\Tests\Extra\Post;
use Spatie\Typed\Types\StringType;
use Spatie\Typed\Tests\Extra\Wrong;
use Spatie\Typed\Types\BooleanType;
use Spatie\Typed\Types\IntegerType;
use Spatie\Typed\Exceptions\WrongType;
use Spatie\Typed\Exceptions\UninitialisedError;

class TupleTest extends TestCase
{
    /** @test */
    public function it_contains_a_fixed_list_of_typed_values()
    {
        $data = (new Tuple(
            new IntegerType(),
            new StringType(),
            new BooleanType())
        )->set(1, 'a', true);

        $this->assertInternalType('array', $data->toArray());
    }

    /** @test */
    public function it_validates_the_types()
    {
        $this->expectException(\TypeError::class);

        $tuple = new Tuple(new Wrong(), new StringType(), new BooleanType());

        $tuple->set(1, 'a', true);
    }

    /** @test */
    public function it_validates_the_amount_of_values()
    {
        $this->expectException(\TypeError::class);

        $tuple = new Tuple(new IntegerType(), new StringType(), new BooleanType());

        $tuple->set(1, 'a', true, true);
    }

    /** @test */
    public function it_validates_the_amount_of_values_when_accessed_via_array_offset()
    {
        $this->expectException(\TypeError::class);

        $tuple = new Tuple(new IntegerType(), new StringType(), new BooleanType());

        $tuple[3] = true;
    }

    /** @test */
    public function it_validates_whether_the_offset_exists()
    {
        $this->expectException(\TypeError::class);

        $tuple = new Tuple(new IntegerType(), new StringType(), new BooleanType());

        $tuple['foo'] = true;
    }

    /** @test */
    public function it_validates_the_type_when_setting_a_value()
    {
        $tuple = new Tuple(T::int(), T::string(), T::bool(), T::nullable(T::generic(Post::class)), T::int()->nullable());

        $tuple[0] = 1;
        $tuple[1] = 'a';
        $tuple[2] = true;
        $tuple[3] = null;
        $tuple[4] = null;

        $this->assertEquals(1, $tuple[0]);
        $this->assertEquals('a', $tuple[1]);
        $this->assertTrue($tuple[2]);
        $this->assertNull($tuple[3]);
    }

    /** @test */
    public function it_validates_the_type_when_setting_a_value_with_the_wrong_type()
    {
        $this->expectException(\TypeError::class);

        $tuple = new Tuple(T::int(), T::string(), T::bool());

        $tuple[0] = new Wrong();
    }

    /** @test */
    public function it_offset_unset_can_not_unset()
    {
        $this->expectException(\TypeError::class);

        $tuple = new Tuple(T::int());

        $tuple->offsetUnset('key');
    }

    /** @test */
    public function types_can_be_inferred()
    {
        $tuple = new Tuple(1, 'a', new Post());

        $this->assertEquals(1, $tuple[0]);
        $this->assertEquals('a', $tuple[1]);
        $this->assertInstanceOf(Post::class, $tuple[2]);

        $tuple[0] = 2;
        $tuple[1] = 'b';
        $tuple[2] = new Post();

        $this->assertEquals(2, $tuple[0]);
        $this->assertEquals('b', $tuple[1]);
        $this->assertInstanceOf(Post::class, $tuple[2]);

        $this->expectException(WrongType::class);

        $tuple[0] = new Wrong();
    }

    /** @test */
    public function uninitialised_values_cannot_be_read()
    {
        $tuple = new Tuple(T::int());

        $this->expectException(UninitialisedError::class);

        $tuple[0];
    }

    /** @test */
    public function types_can_be_partially_inferred()
    {
        $tuple = new Tuple(T::int(), 1, T::string());

        $tuple[0] = 0;
        $tuple[2] = 'a';

        $this->assertEquals(0, $tuple[0]);
        $this->assertEquals(1, $tuple[1]);
        $this->assertEquals('a', $tuple[2]);

        $this->expectException(WrongType::class);

        $tuple[1] = new Wrong();
    }
}
