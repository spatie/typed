<?php

namespace Tests\Typed;

use Typed\Collection;
use Typed\Types\ArrayType;
use Typed\Types\BooleanType;
use Typed\Types\CallableType;
use Typed\Types\CollectionType;
use Typed\Types\FloatType;
use Typed\Types\GenericType;
use Typed\Types\IntegerType;
use Typed\Types\StringType;
use Tests\Post;
use Tests\TestCase;
use Tests\Wrong;
use TypeError;

class TypeTest extends TestCase
{
    /**
     * @test
     * @dataProvider successProvider
     */
    public function test_success($type, $value)
    {
        $collection = new Collection($type);

        $collection[] = $value;

        $this->assertCount(1, $collection);
    }

    /**
     * @test
     * @dataProvider failProvider
     */
    public function test_fail($type, $value)
    {
        $this->expectException(TypeError::class);

        $collection = new Collection($type);

        $collection[] = $value;
    }

    public function successProvider()
    {
        return [
            [ArrayType::class, ['a']],
            [BooleanType::class, true],
            [CallableType::class, function () {}],
            [CollectionType::class, new Collection(ArrayType::class)],
            [FloatType::class, 1.1],
            [new GenericType(Post::class), new Post()],
            [IntegerType::class, 1],
            [StringType::class, 'a'],
        ];
    }

    public function failProvider()
    {
        return [
            [ArrayType::class, new Wrong()],
            [BooleanType::class, new Wrong()],
            [CallableType::class, new Wrong()],
            [CollectionType::class, new Wrong()],
            [FloatType::class, new Wrong()],
            [new GenericType(Post::class), new Wrong()],
            [IntegerType::class, new Wrong()],
            [StringType::class, new Wrong()],
        ];
    }
}
