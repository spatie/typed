<?php

namespace Tests\Typed\Typed;

use Typed\Collection;
use Typed\Lists\GenericList;
use Typed\Struct;
use Typed\T;
use Typed\Tuple;
use Typed\Types\GenericType;
use Tests\HelperClass;
use Tests\Post;
use Tests\TestCase;
use Tests\Wrong;
use TypeError;

class ErrorTest extends TestCase
{
    /** @test */
    public function test_simple_stacktrace()
    {
        $list = new GenericList(Post::class);

        try {
            $list[] = 1;
        } catch (TypeError $e) {
            $line = __LINE__ - 2;

            $fileName = __FILE__;

            $this->assertContains("{$fileName}:{$line}", $e->getMessage());
        }
    }

    /** @test */
    public function test_nested_stacktrace()
    {
        $list = new Collection(new GenericType(Post::class));

        try {
            $list[] = 1;
        } catch (TypeError $e) {
            $line = __LINE__ - 2;

            $fileName = __FILE__;

            $this->assertContains("{$fileName}:{$line}", $e->getMessage());
        }
    }

    /** @test */
    public function test_class_backtrace()
    {
        try {
            new HelperClass();
        } catch (TypeError $e) {
            $this->assertContains('HelperClass.php:13', $e->getMessage());
        }
    }

    /** @test */
    public function test_tuple_backtrace()
    {
        $tuple = new Tuple(T::generic(Wrong::class), T::generic(Wrong::class));

        try {
            $tuple[0] = 'a';
        } catch (TypeError $e) {
            $line = __LINE__ - 2;

            $fileName = __FILE__;

            $this->assertContains("$fileName:{$line}", $e->getMessage());
        }
    }

    /** @test */
    public function test_struct_backtrace()
    {
        $struct = new Struct([
            'name' => T::string(),
        ]);

        try {
            $struct['name'] = new Wrong();
        } catch (TypeError $e) {
            $line = __LINE__ - 2;

            $fileName = __FILE__;

            $this->assertContains("$fileName:{$line}", $e->getMessage());
        }
    }
}
