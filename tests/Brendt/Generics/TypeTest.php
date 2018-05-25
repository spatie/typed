<?php

namespace Spatie\Typed\Tests\Typed;

use Spatie\Typed\Collection;
use Spatie\Typed\Types\ArrayType;
use Spatie\Typed\Types\BooleanType;
use Spatie\Typed\Types\CallableType;
use Spatie\Typed\Types\CollectionType;
use Spatie\Typed\Types\FloatType;
use Spatie\Typed\Types\GenericType;
use Spatie\Typed\Types\IntegerType;
use Spatie\Typed\Types\StringType;
use Spatie\Typed\Tests\Post;
use Spatie\Typed\Tests\TestCase;
use Spatie\Typed\Tests\Wrong;
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
