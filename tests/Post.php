<?php

declare(strict_types=1);

namespace Spatie\Typed\Tests;

class Post
{
    public function foo(): string
    {
        return 'bar';
    }
}
