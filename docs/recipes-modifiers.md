# Recipes & Modifiers

Recipes attach per-input instructions for one action. An input holds one
recipe per identifier (usually the action class); `getRecipe()` returns
`null` when the input has none for that action, so actions must handle
the `null` case.

## FilterRecipe

```php
use Juaniquillo\CrudAssistant\Recipes\FilterRecipe;

$input->setRecipe(new FilterRecipe(
    filter: true,        // remove this input from the dataset
    ignoreIfEmpty: true, // also remove it when its value is '' or null
    callback: static function ($input, array $data): array {
        unset($data[$input->getName()]);
        return $data;
    },
));
```

A callable takes precedence over `filter`. `FilterRecipe::make(...)`
accepts the same arguments.

## LabelValueRecipe

```php
use Juaniquillo\CrudAssistant\Recipes\LabelValueRecipe;

$input->setRecipe(new LabelValueRecipe(
    label: static fn ($input, $model) => sprintf('The %s is', $input->getLabel()),
    value: static fn ($input, $model) => $model->email,
));
```

Plain strings work too; callables receive `($input, $model)`.
`null` label falls back to the input label, `null` value to
`$model->{$name}`.

## Ignore flag

Any recipe can be ignored for a run without removing it:

```php
$recipe->ignore();   // skip this input during execute()
$recipe->ignore(false);
```

## Modifiers

Modifiers transform a value inside an action via
`ModifierInterface::modify($value, $model = null)`. Attach them to a
recipe; the action applies them in order through `IsAction::modifiers()`.

```php
use Juaniquillo\CrudAssistant\Modifiers\BooleanModifier;

$recipe->setModifiers([new BooleanModifier('I Accept')]);
// or one at a time:
$recipe->setModifier(new BooleanModifier('Yes', 'No'));
```

`BooleanModifier(true-label, false-label)` maps truthy/falsy values to
labels. Write your own by implementing `ModifierInterface`.

## Custom recipes

Implement `RecipeInterface` with the `IsRecipe` trait. Declare the
owning action by assigning `$this->action` in the constructor (do not
redeclare the property — the trait owns it):

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

Without `$action`, the identifier falls back to `static::class`.
