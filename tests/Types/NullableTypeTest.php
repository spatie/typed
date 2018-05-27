<?php

declare(strict_types=1);

namespace Spatie\Typed\Tests\Types;

use Spatie\Typed\NullableType;
use PHPUnit\Framework\TestCase;
use Spatie\Typed\Types\NullType;

final class NullableTypeTest extends TestCase
{
    /** @test */
    public function constructor_sets_type(): void
    {
        $type = $this->prophesize(NullableType::class);

        $nullableType = new NullType($type->reveal());

        $this->assertSame($type->reveal(), $nullableType->getType());
    }
}
