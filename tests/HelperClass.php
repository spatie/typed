<?php

namespace Tests;

use Typed\Lists\IntegerList;

class HelperClass
{
    public function __construct()
    {
        $list = new IntegerList();

        $list[] = new Wrong();
    }
}
