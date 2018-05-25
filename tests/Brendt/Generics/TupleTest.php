<?php

namespace Spatie\Typed\Tests\Typed;

use Spatie\Typed\T;
use Spatie\Typed\Tests\TestCase;
use Spatie\Typed\Tests\Wrong;
use Spatie\Typed\Tuple;
use Spatie\Typed\Types\BooleanType;
use Spatie\Typed\Types\IntegerType;
use Spatie\Typed\Types\StringType;

class TupleTest extends TestCase
{
    /** @test */
    public function test_tuple()
    {
        $data = (new Tuple(
            new IntegerType(),
            new StringType(),
            new BooleanType())
        )->set([1, 'a', true]);

        $this->assertTrue(is_array($data->toArray()));
    }

    /** @test */
    public function test_wrong_type()
    {
        $this->expectException(\TypeError::class);

        $tuple = new Tuple(new Wrong(), new StringType(), new BooleanType());

        $tuple->set([1, 'a', true]);
    }

    /** @test */
    public function test_wrong_amount()
    {
        $this->expectException(\TypeError::class);

        $tuple = new Tuple(new IntegerType(), new StringType(), new BooleanType());

        $tuple->set([1, 'a', true, true]);
    }

    /** @test */
    public function test_offset_too_large()
    {
        $this->expectException(\TypeError::class);

        $tuple = new Tuple(new IntegerType(), new StringType(), new BooleanType());

        $tuple[3] = true;
    }

    /** @test */
    public function test_offset_does_not_exist()
    {
        $this->expectException(\TypeError::class);

        $tuple = new Tuple(new IntegerType(), new StringType(), new BooleanType());

        $tuple['foo'] = true;
    }

    /** @test */
    public function test_wrong_type_for_offset()
    {
        $this->expectException(\TypeError::class);

        $tuple = new Tuple(T::int(), T::string(), T::bool());

        $tuple[0] = new Wrong();
    }

    /** @test */
    public function test_offset_set()
    {
        $tuple = new Tuple(T::int(), T::string(), T::bool());

        $tuple[0] = 1;
        $tuple[1] = 'a';
        $tuple[2] = true;

        $this->assertEquals(1, $tuple[0]);
        $this->assertEquals('a', $tuple[1]);
        $this->assertEquals(true, $tuple[2]);
    }
}
