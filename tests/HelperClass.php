<?php

namespace Spatie\Typed\Tests;

use Spatie\Typed\Lists\IntegerList;

class HelperClass
{
    public function __construct()
    {
        $list = new IntegerList();

        $list[] = new Wrong();
    }
}
