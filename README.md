# Improved PHP type system in userland

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/typed.svg?style=flat-square)](https://packagist.org/packages/spatie/typed)
[![Build Status](https://img.shields.io/travis/spatie/typed/master.svg?style=flat-square)](https://travis-ci.org/spatie/typed)
[![StyleCI](https://github.styleci.io/repos/134744208/shield?branch=master)](https://github.styleci.io/repos/134744208)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/typed.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/typed)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/typed.svg?style=flat-square)](https://packagist.org/packages/spatie/typed)

This package is a mere proof of concept about what's possible in PHP's userland to improve type checking. 
It adds support for typed lists, tuples, structs, and generics. 
Because all is done in userland, there are limitations on what syntax is possible.

## Installation

You can install the package via composer:

```bash
composer require spatie/typed
```

## Usage

### Typed lists and collections:

```php
$list = new IntegerList([1, 4]);

$list[] = 'a'; // TypeError
```

```php
$list = new Collection(T::bool(), [true, false]);

$list[] = new Post(); // TypeError
```

### Generics:

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

### Compound Type

A compound type means a collection of multiple types.

```php
$list = new Collection(T::compound(T::int(), T::float()));

$list[] = 1;
$list[] = 1.1;

$list[] = 'abc'; // TypeError
```

Compound types may also be nullable and contain generics.

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

## Support us

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

Does your business depend on our contributions? Reach out and support us on [Patreon](https://www.patreon.com/spatie). 
All pledges will be dedicated to allocating workforce on maintenance and new awesome stuff.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
