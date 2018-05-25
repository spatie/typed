<?php

namespace Spatie\Typed\Tests\Typed;

use TypeError;
use Spatie\Typed\T;
use Spatie\Typed\Struct;
use Spatie\Typed\Tests\Wrong;
use Spatie\Typed\Tests\TestCase;

class StructTest extends TestCase
{
    /** @test */
    public function test_struct()
    {
        $struct = new Struct([
            'name' => T::string(),
            'age'  => T::int(),
            'second_name' => T::nullable(T::string()),
        ]);

        $struct['name'] = 'Brent';

        $struct->set([
            'name' => 'BrenDt',
            'age'  => 23,
            'second_name' => null,
        ]);

        $this->assertEquals('BrenDt', $struct['name']);
        $this->assertEquals(23, $struct->age);
        $this->assertEquals(null, $struct['second_name']);
    }

    /** @test */
    public function wrong_type_when_setting()
    {
        $this->expectException(TypeError::class);

        $struct = new Struct([
            'name' => T::string(),
        ]);

        $struct->name = new Wrong();
    }

    /** @test */
    public function wrong_type_when_setting_with_array_access()
    {
        $this->expectException(TypeError::class);

        $struct = new Struct([
            'name' => T::string(),
        ]);

        $struct['name'] = new Wrong();
    }

    /** @test */
    public function wrong_field()
    {
        $this->expectException(TypeError::class);

        $struct = new Struct([
            'name' => T::string(),
        ]);

        $struct->foo = new Wrong();
    }
}
