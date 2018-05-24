<?php declare(strict_types=1);

namespace Typed;

use Typed\Types\ArrayType;
use Typed\Types\BooleanType;
use Typed\Types\CallableType;
use Typed\Types\CollectionType;
use Typed\Types\FloatType;
use Typed\Types\GenericType;
use Typed\Types\IntegerType;
use Typed\Types\StringType;

class T
{
    public static function array(): ArrayType
    {
        return new ArrayType();
    }

    public static function bool(): BooleanType
    {
        return new BooleanType();
    }

    public static function boolean(): BooleanType
    {
        return new BooleanType();
    }

    public static function callable(): CallableType
    {
        return new CallableType();
    }

    public static function collection(): CollectionType
    {
        return new CollectionType();
    }

    public static function float(): FloatType
    {
        return new FloatType();
    }

    public static function double(): FloatType
    {
        return new FloatType();
    }

    public static function generic(string $type): GenericType
    {
        return new GenericType($type);
    }

    public static function int(): IntegerType
    {
        return new IntegerType();
    }

    public static function integer(): IntegerType
    {
        return new IntegerType();
    }

    public static function string(): StringType
    {
        return new StringType();
    }
}
