# Actions

An action implements behavior over inputs. It receives inputs via
`execute()` and exposes results via `getOutput()` — `execute()` itself
returns `void`.

## Lifecycle

```
prepare() → execute($input) → cleanup()
```

- `prepare()` seeds output (e.g. `FilterAction` loads the dataset).
- `execute()` processes one input or collection.
- `cleanup()` finalizes output.

`InputCollection::execute()` orchestrates this per input; actions that
take over iteration set the flags below. `initOutput()` lazily creates
the default `DataContainer` output.

## Control flags

| Flag | When `true`… |
| --- | --- |
| `controlsExecution` | The action iterates itself via `executeAll()` (`prepare` → `execute($collection)` → `cleanup`). `InputCollection::execute()` returns early after `executeAll()`. |
| `controlsRecursion` | Nested collections are handed to the action whole (`$action->execute($collection)`) so it recurses internally instead of `InputCollection` iterating members. |
| `processInternalCollection` | After running an action over each member of a nested collection, `InputCollection` additionally runs it against the nested collection itself. |

`FilterAction` sets `controlsExecution` and `controlsRecursion`;
`LabelValueAction` leaves all three `false` and handles one input per
call.

## Built-in actions

The shipped actions double as reference implementations — read them as
the canonical examples of how to implement an action before writing
your own.

`FilterAction` removes inputs from a dataset (see
[Getting Started](getting-started.md)). It demonstrates an action that
takes over iteration and recursion (`controlsExecution` and
`controlsRecursion`). Its constructor takes the
dataset; output lands under the `data` key:

```php
$filter = new FilterAction(['name' => '...', 'email' => '...']);
$crud->execute($filter);
$filter->getOutput()->get('data');
```

`LabelValueAction` maps a model object to label-keyed values. It is the
reference for the simplest per-input action: all flags `false`, one input
per call:

```php
$action = new LabelValueAction($model);
$crud->execute($action);
$action->getOutput()->get('Email');
```

`PrepareCleanupAction` is a test/example action demonstrating the
`prepare()`/`cleanup()` hooks.

## Writing a custom action

Start from whichever built-in is closest to your case and adapt it.

```php
use Juaniquillo\CrudAssistant\Action;
use Juaniquillo\CrudAssistant\Contracts\ActionInterface;
use Juaniquillo\CrudAssistant\Contracts\InputCollectionInterface;
use Juaniquillo\CrudAssistant\Contracts\InputInterface;

final class UppercaseAction extends Action implements ActionInterface
{
    public function execute(InputCollectionInterface|InputInterface $input): void
    {
        $output = $this->getOutput();

        // Always resolve through getIdentifier(): identifiers are
        // overridable, so a class literal would bypass overrides.
        $recipe = $input->getRecipe(static::getIdentifier());
        $value = $recipe instanceof MyRecipe ? $recipe->value : $input->getName();
        // ... transform and store on $output
    }
}
```

Extend `Action` (brings `IsAction`: output handling, flags, `modifiers()`,
`isEmpty()`), implement the rest of `ActionInterface`
(`prepare`/`cleanup` inherit usable defaults), and read results with
`getOutput()`. Keep per-input helpers `private` — only `execute()` is
public API.

Inside an action, always look recipes up through `getIdentifier()`
(`$this->` or `static::`), never a class literal: identifiers are
overridable, and a literal would bypass the override. Class literals are
for outside wiring only — `setRecipe()`, tests, one-off lookups.
