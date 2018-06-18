<?php

namespace Spatie\Typed\Tests\Benchmarks;

use Spatie\Typed\Collection;
use Spatie\Typed\T;

class ListBenchmarkTest extends BenchmarkTest
{
    /** @test */
    public function array_write()
    {
        $array = [];

        $this->startTimer();

        foreach (range(1, 1000000) as $i) {
            $array[] = $i;
        }

        $this->output('array write', $this->stopTimer());

        $this->addToAssertionCount(1);
    }

    /** @test */
    public function typed_write()
    {
        $list = new Collection(T::int());

        $this->startTimer();

        foreach (range(1, 1000000) as $i) {
            $list[] = $i;
        }

        $this->output('typed write', $this->stopTimer());
    }

    /** @test */
    public  function array_read()
    {
        $array = [];

        foreach (range(1, 1000000) as $i) {
            $array[] = $i;
        }

        $this->startTimer();

        foreach ($array as $item) {
            // Do nothing
        }

        $this->output('array read', $this->stopTimer());

        $this->addToAssertionCount(1);
    }

    /** @test */
    public function typed_read()
    {
        $list = new Collection(T::int());

        foreach (range(1, 1000000) as $i) {
            $list[] = $i;
        }

        $this->startTimer();

        foreach ($list as $item) {
            // Do nothing
        }

        $this->output('typed read', $this->stopTimer());
    }
}
