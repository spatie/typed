This package is a mere proof of concept about what's possible in PHP's userland to improve type checking. 
It adds support for typed lists, tuples, structs, and generics. 
Because all is done in userland, there are limitations on what syntax is possible.

#### Typed lists and collections:

```php
$list = new IntegerList([1, 4]);

$list[] = 'a'; // TypeError
```

```php
$list = new Collection(T::bool(), [true, false]);

$list[] = new Post(); // TypeError
```

#### Generics:

```php
$postList = new Collection(T::generic(Post::class));

$postList = 1; // TypeError
```

#### Tuples:

```php
$point = new Tuple(T::float(), T::float());

$point[0] = 1.5;
$point[1] = 3;

$point[0] = 'a'; // TypeError
$point['a'] = 1; // TypeError
$point[10] = 1; // TypeError
```

#### Structs:

```php
$developer = new Struct([
    'name' => T::string(),
    'age' => T::int(),
]);

$developer['name'] = 'Brent';

$developer->set([
    'name' => 'BrenDt',
    'age' => 23,
]);

echo $developer->age;

$developer->name = 'Brent';

$developer->age = 'abc' // TypeError
$developer->somethingElse = 'abc' // TypeError
```

#### What's not included:

- Proper syntax.
- IDE auto completion for generic types.
- Prevention of type casting between scalar types.
- Nullable types, though I could add it.

## Why bother?

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

$postList = new Collection(T::generic(Post::class));
```

Anyways, it's stuff to think about. 
And maybe PHP's type system is fine as it is now? 
You can read more about type safety [on my blog](https://www.stitcher.io/blog/liskov-and-type-safety).
