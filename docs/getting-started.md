# Getting Started

## Install

```bash
composer require juaniquillo/crud-assistant
```

Requires PHP `^8.3`.

## The idea

Crud Assistant separates **what** a form contains from **what happens**
with it:

- **Inputs** describe fields (`TextInput`, `SelectInput`, collections).
- **Actions** implement behavior (`FilterAction`, `LabelValueAction`,
  your own). One action runs over many inputs.
- **Recipes** attach per-input instructions for a specific action.
- **Containers** (`DataContainer`) carry the data in and out.

Change a field once on its `Input` and every action picks it up.

## Minimal example

```php
use Juaniquillo\CrudAssistant\Actions\FilterAction;
use Juaniquillo\CrudAssistant\CrudAssistant;
use Juaniquillo\CrudAssistant\Inputs\TextInput;
use Juaniquillo\CrudAssistant\Recipes\FilterRecipe;

$name = new TextInput('name', 'Name');
$email = new TextInput('email', 'Email');
$email->setRecipe(new FilterRecipe(filter: true));

$crud = CrudAssistant::make([$name, $email]);

$filtered = $crud->execute(new FilterAction([
    'name' => 'Victor Sánchez',
    'email' => 'email@email.com',
]));

$filtered->get('data'); // ['name' => 'Victor Sánchez']
```

`execute()` on an action returns `void`; results come from
`getOutput()`. `Input`/`InputCollection::execute()` still return the
output container directly, as above.

## Next

- [Inputs](inputs.md) — fields, nesting, partials
- [Actions](actions.md) — lifecycle, flags, custom actions
- [Recipes & Modifiers](recipes-modifiers.md) — per-input instructions
- [Containers](containers.md) — `DataContainer` generics and semantics
- [Upgrade guide](../UPGRADE.md) — breaking changes in 0.3.0
