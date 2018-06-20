<?php

namespace Spatie\Typed\Tests\Benchmarks;

use Spatie\Typed\T;
use Spatie\Typed\Tuple;

class TupleBenchmarkTest extends BenchmarkTest
{
    /** @test */
    public function array_write()
    {
        $this->start();

        $tuple = [1, 'a'];

        $this->stop();
    }

    /** @test */
    public function tuple_write()
    {
        $this->start();

        $tuple = (new Tuple(T::int(), T::string()))->set([1, 'a']);

        $this->stop();
    }
}
