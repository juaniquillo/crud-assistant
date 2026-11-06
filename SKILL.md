---
name: crud-assistant
description: Build and change small-project CRUD flows with crud-assistant Inputs, Actions, Recipes, and DataContainers. Use when creating form pipelines, filtering datasets, mapping models to labels, or extending the package with custom actions, recipes, or modifiers.
---

# Crud Assistant

Organization-first toolkit: business logic lives in `Inputs`, behavior in
`Action`s, per-input instructions in `Recipe`s, data in `DataContainer`s.

## Canonical pipeline

```php
use Juaniquillo\CrudAssistant\Actions\FilterAction;
use Juaniquillo\CrudAssistant\CrudAssistant;
use Juaniquillo\CrudAssistant\Inputs\TextInput;
use Juaniquillo\CrudAssistant\Recipes\FilterRecipe;

$email = new TextInput('email', 'Email');
$email->setRecipe(new FilterRecipe(filter: true));

$crud = CrudAssistant::make([$email]);
$filtered = $crud->execute(new FilterAction(['email' => 'a@b.c']));
$filtered->get('data'); // [] — email was filtered out
```

## Rules that matter

- `Action::execute()` returns `void`. Always read results from
  `$action->getOutput()`. (`Input`/`InputCollection::execute()` return the
  container.)
- `Input::getRecipe()` returns `null` when the input has no recipe for
  that action. Handle `null` with `->` + `??` (isset semantics), never
  assume a recipe exists. Prefer `instanceof` narrowing to read
  recipe-specific properties (base `RecipeInterface` declares none).
- Collections nest (`InputCollection` is an `Input`). Use
  `InputHelper::isCollection($input)` to distinguish them.
- Missing container keys throw `InvalidArgumentException`; keys set to
  `null` exist (`get` returns `null`, `contains` is `true`).
- Custom actions extend `Action`, implement `ActionInterface`
  (`execute(InputCollectionInterface|InputInterface): void`), keep helpers
  `private`, expose state only via `getOutput()`. Read the built-in
  actions in `src/Actions/` first — they are the reference
  implementations.
- Custom recipes implement `RecipeInterface` with `IsRecipe`, assign
  `$this->action` in the constructor, never redeclare the property.
- Custom modifiers implement `ModifierInterface::modify($value, $model)`.
- Containers are `DataContainerInterface<TValue>` (keys `array-key`).

## Reference

- `docs/getting-started.md` — install, minimal example
- `docs/inputs.md` — fields, nesting, partials
- `docs/actions.md` — lifecycle, control flags, custom actions
- `docs/recipes-modifiers.md` — recipes, ignore flag, modifiers
- `docs/containers.md` — container API and null semantics
- `UPGRADE.md` — every 0.3.0 breaking change with before/after code
