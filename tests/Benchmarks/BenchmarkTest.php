<?php

namespace Spatie\Typed\Tests\Benchmarks;

use Spatie\Typed\Tests\TestCase;
use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Component\Stopwatch\StopwatchEvent;

abstract class BenchmarkTest extends TestCase
{
    /** @var \Symfony\Component\Stopwatch\Stopwatch */
    protected $timer;

    protected function startTimer()
    {
        $this->timer->start('current');
    }

    protected function stopTimer(): StopwatchEvent
    {
        $this->timer->stop('current');

        return $this->timer->getEvent('current');
    }

    protected function setUp()
    {
        parent::setUp();

        $this->timer = new Stopwatch(true);
    }

    protected function tearDown()
    {
        $this->addToAssertionCount(1);

        parent::tearDown();
    }

    protected function output(string $name, StopwatchEvent $event)
    {
        $title = "======= {$name} =======";

        $subtitle = str_repeat('=', strlen($title));

        $output = <<<EOL

{$title}
 End time: {$event->getEndTime()} ms
 Memory: {$this->formatMemory($event->getMemory())}
{$subtitle}

EOL;

        fwrite(STDOUT, $output);
    }

    protected function formatMemory(int $bytes): string
    {
        return round($bytes / 1000000, 3).' MB';
    }
}
