<?php

declare(strict_types=1);

namespace Spatie\Typed\Tests;

use Spatie\Typed\Tests\Extra\Wrong;
use TypeError;
use Spatie\Typed\T;
use Spatie\Typed\Struct;

class StructTest extends TestCase
{
    /** @test */
    public function it_contains_a_fixed_set_of_typed_fields()
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
    public function it_validates_types_with_property_access()
    {
        $this->expectException(TypeError::class);

        $struct = new Struct([
            'name' => T::string(),
        ]);

        $struct->name = new Wrong();
    }

    /** @test */
    public function it_validates_types_with_array_access()
    {
        $this->expectException(TypeError::class);

        $struct = new Struct([
            'name' => T::string(),
        ]);

        $struct['name'] = new Wrong();
    }

    /** @test */
    public function it_validates_types_whith_unknown_fields()
    {
        $this->expectException(TypeError::class);

        $struct = new Struct([
            'name' => T::string(),
        ]);

        $struct->foo = new Wrong();
    }
}
