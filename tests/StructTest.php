<?php

declare(strict_types=1);

namespace Spatie\Typed\Tests;

use TypeError;
use Spatie\Typed\T;
use Spatie\Typed\Struct;
use Spatie\Typed\Tests\Extra\Wrong;

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
    public function it_validates_types_with_unknown_fields()
    {
        $this->expectException(TypeError::class);

        $struct = new Struct([
            'name' => T::string(),
        ]);

        $struct->foo = new Wrong();
    }

    /** @test */
    public function it_set_throws_with_missing_field()
    {
        $this->expectException(TypeError::class);

        $struct = new Struct([
            'name' => T::string(),
            'age'  => T::int(),
            'second_name' => T::nullable(T::string()),
        ]);

        $struct['name'] = 'Brent';

        $struct->set([
            'age'  => 23,
            'second_name' => null,
        ]);
    }

    /** @test */
    public function it_offset_exists()
    {
        $struct = new Struct([
            'name' => T::string(),
        ]);

        $struct->set([
            'name' => 'Lee',
        ]);

        $this->assertTrue($struct->offsetExists('name'));
        $this->assertFalse($struct->offsetExists('age'));
    }

    /** @test */
    public function it_offset_unset_can_not_unset()
    {
        $this->expectException(TypeError::class);

        $struct = new Struct([
            'name' => T::string(),
        ]);

        $struct->set([
            'name' => 'Lee',
        ]);

        $struct->offsetUnset('name');
    }

    /** @test */
    public function it_can_let_structp_return_array()
    {
        $struct = new Struct([
            'name' => T::string(),
            'age' => T::integer(),
            'height' => T::float(),
            'weight' => T::double(),
            'is_smoke' => T::boolean(),
            'families' => T::array(),
        ]);

        $struct->set([
            'name' => 'Lee',
            'age' => 23,
            'height' => 177.5,
            'weight' => 69.5,
            'is_smoke' => false,
            'families' => [
                'mom', 'dad', 'uncle', 'aunt',
            ],
        ]);

        $this->assertSame([
            'name' => 'Lee',
            'age' => 23,
            'height' => 177.5,
            'weight' => 69.5,
            'is_smoke' => false,
            'families' => [
                'mom', 'dad', 'uncle', 'aunt',
            ],
        ], $struct->toArray());
    }
}
