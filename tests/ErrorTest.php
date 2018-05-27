<?php

namespace Spatie\Typed\Tests;

use TypeError;
use Spatie\Typed\T;
use Spatie\Typed\Tuple;
use Spatie\Typed\Struct;
use Spatie\Typed\Collection;
use Spatie\Typed\Lists\GenericList;
use Spatie\Typed\Types\GenericType;

class ErrorTest extends TestCase
{
    /** @test */
    public function simple_stacktrace()
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
    public function nested_stacktrace()
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
    public function class_backtrace()
    {
        try {
            new HelperClass();
        } catch (TypeError $e) {
            $this->assertContains('HelperClass.php:13', $e->getMessage());
        }
    }

    /** @test */
    public function tuple_backtrace()
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
    public function struct_backtrace()
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
