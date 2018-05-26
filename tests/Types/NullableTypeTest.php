<?php

declare(strict_types=1);

namespace Spatie\Typed\Tests\Types;

use Spatie\Typed\Nullable;
use PHPUnit\Framework\TestCase;
use Spatie\Typed\Types\NullableType;

final class NullableTypeTest extends TestCase
{
    /** @test */
    public function constructor_sets_type(): void
    {
        $type = $this->prophesize(Nullable::class);

        $nullableType = new NullableType($type->reveal());

        $this->assertSame($type->reveal(), $nullableType->getType());
    }
}
