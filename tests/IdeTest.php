<?php

declare(strict_types=1);

namespace Spatie\Typed\Tests;

use Spatie\Typed\Tests\Extra\Vector;
use Spatie\Typed\Tests\Extra\VectorList;

class IdeTest extends TestCase
{
    /** @test */
    public function a()
    {
        $vector = new Vector(1, 1, 2, 2);

        $list = new VectorList([$vector]);

        foreach ($list as $item) {
            $item->a->getX();
        }
    }
}
