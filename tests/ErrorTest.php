<?php

declare(strict_types=1);

namespace Spatie\Typed\Tests;

use Spatie\Typed\Tests\Extra\HelperClass;
use Spatie\Typed\Tests\Extra\Post;
use Spatie\Typed\Tests\Extra\Wrong;
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
    public function collection_stacktrace_shows_correct_line()
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
    public function nested_stacktrace_shows_correct_line()
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
    public function error_in_class_backtrace_shows_correct_line()
    {
        try {
            new HelperClass();
        } catch (TypeError $e) {
            $this->assertContains('HelperClass.php:15', $e->getMessage());
        }
    }

    /** @test */
    public function tuple_stacktrace_shows_correct_line()
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
    public function struct_stacktrace_shows_correct_line()
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
