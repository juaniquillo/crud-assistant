# Inputs

An `Input` is a field: a name, a label, attributes, and optional
recipes. Available inputs: `TextInput`, `TextareaInput`, `SelectInput`,
`OptionInput`, `RadioInput`, `RadioGroupInput`, `CheckboxInput`,
`FileInput`, `DefaultInput`.

```php
use Juaniquillo\CrudAssistant\Inputs\TextInput;

$input = new TextInput('email', 'Email');
$input->setType('email')
    ->setAttribute('placeholder', 'you@example.com')
    ->setVersion(2);
```

## Attributes are shared, recipes are addressed

Attributes are visible to **every** action via `getAttributes()`. That
makes them the right channel for concerns several actions share (rendering:
`type`, `placeholder`), and the wrong channel for anything only one
action consumes. As the action list grows (`FormAction`,
`HTMLTableAction`, `ValidationAction`, `CsvExportAction`), per-action
keys in the shared bag collide and every action must defensively ignore
everyone else's keys.

Rule: if exactly one action consumes a setting, it belongs in that
action's `Recipe`. If several do, it's an attribute.

```php
// Anti-pattern: only ValidationAction reads this, but every action sees it.
$input->setAttribute('validation', 'required|email');

// Instead: addressed to one action, invisible to the rest
// (ValidationRecipe here stands for your action's recipe class).
$input->setRecipe(new ValidationRecipe(rules: ['required', 'email']));
```

## Scoping inputs to actions

`onlyFor()` limits which actions process the input; `isFor()` checks it.
`InputCollection::execute()` skips inputs that are ignored or not for the
running action.

```php
use Juaniquillo\CrudAssistant\Actions\FilterAction;
use Juaniquillo\CrudAssistant\Actions\LabelValueAction;

$input->onlyFor([FilterAction::getIdentifier(), LabelValueAction::getIdentifier()]);
```

## Recipes

`setRecipe()` stores instructions keyed by the recipe's identifier
(usually its action class). See [Recipes & Modifiers](recipes-modifiers.md).

```php
$input->setRecipe(new FilterRecipe(filter: true));
$input->getRecipe(FilterAction::getIdentifier());
```

## Collections and nesting

`InputCollection` is itself an `Input`, so forms nest recursively:

```php
use Juaniquillo\CrudAssistant\InputCollection;

$extra = new InputCollection('extra_info');
$extra->setInputs([$nickname, $hobby]);

$crud = CrudAssistant::make([$name, $email, $extra]);
```

Useful members: `addInput($input, $key = null)`,
`removeInput($key)`, `getInput($key)` (throws when missing),
`has($key)`, `getInputs($all = false)`, `getInputNames()`,
`getInputLabels()`, `count()`.

`InputHelper::isCollection($input)` tells collections apart from plain
inputs.

## Partial collections

`setPartialCollection(['name', 'email'])` restricts iteration to a
subset without removing the other inputs. `getInputs(all: true)` bypasses
the restriction.

## Prepare / cleanup suppression

Nested collections disable their own `prepare()`/`cleanup()` when an
outer collection drives execution (`disablePrepare()`,
`disableCleanup()`), so lifecycle hooks run once at the top level.
