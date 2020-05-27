# Improved PHP type system in userland

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/typed.svg?style=flat-square)](https://packagist.org/packages/spatie/typed)
[![Build Status](https://img.shields.io/travis/spatie/typed/master.svg?style=flat-square)](https://travis-ci.org/spatie/typed)
[![StyleCI](https://github.styleci.io/repos/134744208/shield?branch=master)](https://github.styleci.io/repos/134744208)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/typed.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/typed)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/typed.svg?style=flat-square)](https://packagist.org/packages/spatie/typed)

This package is a mere proof of concept about what's possible in PHP's userland to improve type checking. 
It adds support for type inference, generics, union types, typed lists, tuples and structs.
Because all is done in userland, there are limitations on what syntax is possible.

## Support us

Learn how to create a package like this one, by watching our premium video course:

[![Laravel Package training](https://spatie.be/github/package-training.jpg)](https://laravelpackage.training)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require spatie/typed
```

## Usage

### Type inference

Both collections, tuples and structs support inferred types. 
This means that all examples are also possible, without manually specifying types.
For example:

```php
// This collection will only allow objects of type `Post` in it.
$postCollection = new Collection([new Post()]);

// This tuple will keep its signature of (Point, Point).
$vector = new Tuple(new Point(30, 5), new Point(120, 0));

// This struct's fields are autmoatically type checked.
$struct = [
    'foo' => new Post(),
    'bar' => function () {
        // ...
    },
];
```

The following examples all show the manual type configuration. 
There are some cases where type inference falls short, and you have to fall back on manually defining them.
You might also prefer the manual approach, for clarity's sake.

Note that type may be partially inferred. 
Some fields in tuples or structs may be type definitions, others may be real values.
Uninitialised types will throw an error on read. 

### Typed lists and collections:

```php
$list = new Collection(T::bool());

$list[] = new Post(); // TypeError
```

It's possible to directly initialise a collection with data after construction.

```php
$list = (new Collection(T::string()))->set(['a', 'b', 'c']);
```

This package also provides some predefined lists, as shortcuts.

```php
$list = new IntegerList([1, 4]);

$list[] = 'a'; // TypeError
```

### Generics:

Generic types wrap around classes, allowing you to not creating a custom type for every class.

```php
$postList = new Collection(T::generic(Post::class));

$postList[] = 1; // TypeError
```

### Tuples:

```php
$point = new Tuple(T::float(), T::float());

$point[0] = 1.5;
$point[1] = 3;

$point[0] = 'a'; // TypeError
$point['a'] = 1; // TypeError
$point[10] = 1; // TypeError
```

Like lists, a tuple can also be given some data after construction with the `set` function.

```php
$tuple = (new Tuple(T::string(), T::array()))->set('abc', []);
```

### Structs:

```php
$developer = new Struct([
    'name' => T::string(),
    'age' => T::int(),
    'second_name' => T::nullable(T::string()),
]);

$developer['name'] = 'Brent';
$developer['second_name'] = 'John';

$developer->set([
    'name' => 'BrenDt',
    'age' => 23,
    'second_name' => null,
]);

echo $developer->age;

$developer->name = 'Brent';

$developer->age = 'abc' // TypeError
$developer->somethingElse = 'abc' // TypeError
```

### Nullable type

A nullable type can be defined in two, functionally identical, ways:

```php
$list1 = new Collection(T::int()->nullable());

$list2 = new Collection(T::nullable(T::int()));
```

### Union Type

A union type means a collection of multiple types.

```php
$list = new Collection(T::union(T::int(), T::float()));

$list[] = 1;
$list[] = 1.1;

$list[] = 'abc'; // TypeError
```

Union types may also be nullable and contain generics.

### What's not included:

- Proper syntax.
- IDE auto completion for generic types.
- Prevention of type casting between scalar types.
- Type hint generics in functions.

## Creating your own types

The `GenericType` or `T::generic()` can be used to create structures of that type.
It is, however, also possible to create your own types without generics. 
Let's take the example of `Post`. The generic approach works without adding custom types.

```php
$postList = new Collection(T::generic(Post::class));

$postList[] = new Post();
$postList[] = 1; // TypeError 
```

The `generic` part can be skipped if you create your own type.

```php
use Spatie\Typed\Type;
use Spatie\Typed\Types\Nullable;

class PostType implements Type
{
    use Nullable;
    
    public function validate($post): Post
    {
        return $post;
    }
}
```

Now you can use `PostType` directly:

```php
$postList = new Collection(new PostType());
```

You're also free to extend the `T` helper.

```php
class T extends Spatie\Typed\T
{
    public static function post(): PostType
    {
        return new PostType();
    }
}

// ...

$postList = new Collection(T::post());
```

The `Nullable` trait adds the following simple snippet, 
so that the type can be made nullable when used.

```php
public function nullable(): NullType
{
    return new NullType($this);
}
```

> **Note:** It's recommended to also implement `__toString` in your own type classes. 

## Extending data structures

You're free to extend the existing data structures. 
For example, you could make shorthand tuples like so:

```php
class Coordinates extends Tuple
{
    public function __construct(int $x, int $y)
    {
        parent::__construct(T::int(), T::int());

        $this[0] = $x;
        $this[1] = $y;
    }
}
```

## Why did we build this?

PHP has a very weak type system. 
This is simultaneously a strength and a weakness. 
Weak type systems offer a very flexible development platform,
while strong type systems can prevent certain bugs from happening at runtime.

In its current state, PHP's type system isn't ready for some of the features many want. 
Take, for example, a look at some RFC's proposing changes to the current type system.

- Generics: [https://wiki.php.net/rfc/generics](https://wiki.php.net/rfc/generics)
- Typed properties: [https://wiki.php.net/rfc/typed-properties](https://wiki.php.net/rfc/typed-properties)
- Readonly properties: [https://wiki.php.net/rfc/readonly_properties](https://wiki.php.net/rfc/readonly_properties)

Some of those are already declined because of runtime performance issues, or implementation difficulties.
This package is a thought experiment of what we could do if those features are implemented in PHP, usable with native syntax.

For example, the following syntax would be much more preferable over how this package does it.

```php
$postList = new Collection<Post>();

// vs.

$postList[] = new Collection(T::generic(Post::class));
```

Anyways, it's stuff to think about. 
And maybe PHP's type system is fine as it is now? 
You can read more about type safety [on my blog](https://www.stitcher.io/blog/liskov-and-type-safety).

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Postcardware

You're free to use this package, but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Samberstraat 69D, 2060 Antwerp, Belgium.

We publish all received postcards [on our company website](https://spatie.be/en/opensource/postcards).

## Credits

- [Brent Roose](https://github.com/brendt)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
