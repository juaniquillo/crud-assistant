# Upgrade Guide — 0.2.x to 0.3.0

This is a breaking release on the 0.x line (minor bump carries the
breaks). Breaking changes are listed below with
before/after examples. In all snippets, `getOutput()` returns
`DataContainerInterface<mixed>`.

## PHP and tooling floors

- PHP: `^8.2` → `^8.3`
- PHPUnit: `^9.5` → `^12` (configuration migrated to the 12.5 schema)
- PHPStan: level `6` → `8`
- CI runs the matrix `['8.3', '8.4']` and enforces `composer run format:check`

## `DataContainer::add()` is now `merge()`

```php
// Before
$container->add(['another' => 'day']);

// After
$container->merge(['another' => 'day']);
```

## `CrudAssistant` helpers removed

`CrudAssistant::isInputCollection()` and `CrudAssistant::isClosure()`
are gone. Collection checks live in the new `Support` helper:

```php
use Juaniquillo\CrudAssistant\Support\InputHelper;

// Before
CrudAssistant::isInputCollection($input);

// After
InputHelper::isCollection($input);

// Closures: inline the check
$instance instanceof \Closure;
```

## `InputCollection::isset()` is now `has()`

```php
// Before
$form->isset('name');

// After
$form->has('name');
```

## Deleted base classes and helpers

- `Juaniquillo\CrudAssistant\RecipeContainer` — implement
  `RecipeInterface` directly or `use IsRecipe`.
- `Juaniquillo\CrudAssistant\Modifier` — implement
  `ModifierInterface` directly (e.g. `BooleanModifier` does).
- `dumpIt()` and the `helpers/helpers.php` autoload — removed without
  replacement.
- `#[\AllowDynamicProperties]` on `DataContainer` — removed. All access
  already flows through `__get`/`__set` into the container, so no change
  is needed unless you relied on real dynamic properties (now an error).

## Actions no longer return output from `execute()`

`ActionInterface::execute()` returns `void`. Read results from
`getOutput()`. `Input`/`InputCollection::execute()` still return the
output container.

```php
// Before
$result = $action->execute($input);

// After
$action->execute($input);
$result = $action->getOutput();
```

`FilterAction::executeOne()` is no longer public API (now `private`).
Loop over `execute()` per input instead:

```php
// Before
foreach ($inputs as $input) {
    $filter->executeOne($input);
}

// After
foreach ($inputs as $input) {
    $filter->execute($input);
}
$filtered = $filter->getOutput();
```

## `InputCollectionInterface` changes

- Now extends `\IteratorAggregate` (`@extends` with `InputInterface`
  values), so `foreach` over a collection type-checks everywhere.
- `getInputNames()` / `getInputLabels()` return
  `array<int|string, string|null>` — names and labels were always
  nullable (`getName(): ?string`), the old `string` docblock was wrong.

## Generic `DataContainerInterface<TValue>`

The container contract is generic over values only; keys are always
`array-key`. The earlier two-parameter form is gone:

```php
/** @return DataContainerInterface<array-key, mixed> */ // Before
/** @return DataContainerInterface<mixed> */            // After
```

`DataContainer` and `FilterContainer` implement only
`DataContainerInterface` now (SPL interfaces are inherited), and
`make()` returns `static`.

## Null values count as existing keys

`get()`, `contains()`, and `missing()` use `array_key_exists()`
semantics. A key set to `null` is found instead of throwing or
reporting missing:

```php
$container = new DataContainer(['name' => null]);
$container->get('name');          // null (previously threw)
$container->contains(['name']);   // true (previously false)
```

`__isset()` / `offsetExists()` intentionally keep `isset()` semantics
(`isset($c->name)` is still `false` for `null`), matching native arrays.

## Custom recipes: `$action` moved into the trait

`IsRecipe` now declares `protected ?string $action = null`
(`class-string<ActionInterface>|null`). If your own recipe declares that
property, delete the declaration (redeclaring it is a fatal error) and
assign it in the constructor, as the built-in recipes do:

```php
use Juaniquillo\CrudAssistant\Actions\FilterAction;
use Juaniquillo\CrudAssistant\Concerns\IsRecipe;
use Juaniquillo\CrudAssistant\Contracts\RecipeInterface;

final class MyRecipe implements RecipeInterface
{
    use IsRecipe;

    public function __construct(
        public readonly bool $filter = true,
    ) {
        $this->action = FilterAction::class;
    }
}
```

Recipes without an `$action` fall back to `static::class` as identifier.

## Narrowed `execute()` signatures

Actions accept `InputCollectionInterface|InputInterface` (previously the
concrete `InputCollection` plus a raw `\IteratorAggregate`). Passing an
arbitrary `Traversable` whose values are not inputs no longer
type-checks. `IsAction::isEmpty()` now returns `bool` instead of
`mixed`.

## Worked example: migrating a real action

Distilled from a `TableRowsAction` / `TableRowsRecipe` pair (presenter
action with a per-row recipe). The recipe lookup already used
`$this->getIdentifier()`, so it survives untouched — everything else is
mechanical:

```php
// Recipe — before
final class TableRowsRecipe implements RecipeInterface
{
    use IsRecipe;

    protected $action = TableRowsAction::class;
}

// Recipe — after: the trait owns $action, assign it in the constructor
final class TableRowsRecipe implements RecipeInterface
{
    use IsRecipe;

    public function __construct(/* ... */)
    {
        $this->action = TableRowsAction::class;
    }
}
```

```php
// Action — before
use Juaniquillo\CrudAssistant\InputCollection;

public function execute(InputCollection|InputInterface|IteratorAggregate $input)
{
    /** @var TableRowsRecipe $recipe */
    $recipe = $input->getRecipe($this->getIdentifier());
    // ...
    return $output;
}

// Action — after
use Juaniquillo\CrudAssistant\Contracts\InputCollectionInterface;

public function execute(InputCollectionInterface|InputInterface $input): void
{
    $recipe = $input->getRecipe($this->getIdentifier());
    $label = $recipe instanceof TableRowsRecipe ? $recipe->label : null;
    // ...
    // no return; results stay in $this->getOutput()
}
```

Notes:

- `cleanup(): static` / `prepare(): static` are unchanged — the example's
  `cleanup()` was already correct.
- `$this->output = new DataContainer;` in the constructor is redundant
  now (`getOutput()` lazily creates it via `initOutput()`); removing it
  is optional cleanup, not a break.
- Helper defaults like `resolveValue(..., $recipe = new TableRowsRecipe)`
  still work, but prefer a `null` default with `instanceof` narrowing:
  the base `RecipeInterface` declares no `->value` / `->label`, so the
  old `@var` + `-> ??` hides the `null`-recipe case instead of handling
  it.
