# Containers

`DataContainer` is the generic key/value bag actions read and write;
`FilterContainer` is its sibling used by `FilterAction`. Both share the
`IsDataContainer` implementation behind `DataContainerInterface<TValue>`
(keys are always `array-key`).

## Basic use

```php
use Juaniquillo\CrudAssistant\DataContainer;

$container = DataContainer::make(['name' => 'John']);
$container->set('email', 'john@email.com');
$container->get('email');        // 'john@email.com'
$container->merge(['a' => 1]);   // key-wise merge (was add() in 0.2.x)
$container->push('value');       // append with int key
$container->fill(['fresh' => 1]);// replace all data
$container->toArray();           // same as all()
count($container);
```

Property, array, and iterator access all work and behave alike:

```php
$container->email;     // throws InvalidArgumentException when missing
$container['email'];   // same
isset($container->email);
unset($container->email);
foreach ($container as $key => $value) { /* ... */ }
echo $container;       // JSON ('{}' when empty)
```

Missing-key reads (`get`, `__get`, `offsetGet`) throw
`InvalidArgumentException` naming the key.

## Null semantics

A key set to `null` **exists**:

```php
$container = new DataContainer(['name' => null]);
$container->get('name');        // null, no throw
$container->contains(['name']); // true
$container->missing(['name']);  // false
```

while `isset($container->name)` stays `false`, matching native PHP
arrays. `contains($keys)` / `missing($keys)` answer "are these keys
present" over a list of keys.

## Generics

```php
/** @var DataContainerInterface<string> $container */
```

Bind `TValue` when the value type is known; reads (`get`, `toArray`,
iteration) then carry it. Writes accept `array-key` keys and are
unchecked beyond that — see [Upgrade guide](../UPGRADE.md) for why the
older two-parameter form was dropped.
