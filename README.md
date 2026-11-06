# Crud Assistant

[![CI](https://github.com/juaniquillo/crud-assistant/actions/workflows/ci.yml/badge.svg)](https://github.com/juaniquillo/crud-assistant/actions/workflows/ci.yml)

Utilities for CRUD management and component re-use. One goal:
**organization** — consolidate business logic in `Inputs` and
implementation code in `Actions`, so form changes land in one place.

> [!NOTE]
>
> #### About this fork.
>
> This repository is a fork of [ChatAgency/crud-assistant](https://github.com/ChatAgency/crud-assistant).
> It is now maintained independently as `juaniquillo/crud-assistant`.

## Install

```bash
composer require juaniquillo/crud-assistant
```

Requires PHP `^8.3`.

## Use

```php
use Juaniquillo\CrudAssistant\Actions\FilterAction;
use Juaniquillo\CrudAssistant\CrudAssistant;
use Juaniquillo\CrudAssistant\Inputs\TextInput;
use Juaniquillo\CrudAssistant\Recipes\FilterRecipe;

$email = new TextInput('email', 'Email');
$email->setRecipe(new FilterRecipe(filter: true));

$crud = CrudAssistant::make([$email]);
$filtered = $crud->execute(new FilterAction(['email' => 'a@b.c']));
```

Start with [docs/getting-started.md](docs/getting-started.md), then:

- [Inputs](docs/inputs.md) — fields, nesting, partials
- [Actions](docs/actions.md) — lifecycle, flags, custom actions
- [Recipes & Modifiers](docs/recipes-modifiers.md) — per-input instructions
- [Containers](docs/containers.md) — data bags and null semantics

Upgrading from 0.2.x? Read [UPGRADE.md](UPGRADE.md) first — 0.3.0 breaks
several APIs. Agent developers: see [SKILL.md](SKILL.md).

## License

This package is licensed with the [MIT License](https://choosealicense.com/licenses/mit/#).
