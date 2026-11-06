# Changelog

## 0.3.0

Breaking release on the 0.x line. Full list with before/after code in [UPGRADE.md](UPGRADE.md).

**Breaking:**

- `DataContainer::add()` renamed to `merge()`.
- `CrudAssistant::isInputCollection()` / `isClosure()` removed; collection
  checks moved to `Support\InputHelper::isCollection()`.
- `InputCollection::isset()` renamed to `has()`.
- `RecipeContainer`, `Modifier` base classes and the `dumpIt()` helper
  deleted.
- `ActionInterface::execute()` returns `void`; read via `getOutput()`.
  `FilterAction::executeOne()` is no longer public API.
- `InputCollectionInterface` extends `IteratorAggregate`;
  `getInputNames()` / `getInputLabels()` may contain `null`.
- `DataContainerInterface` is generic over values only (`<TValue>`);
  the two-parameter form is gone.
- `IsRecipe::$action` moved into the trait; custom recipes assign it in
  the constructor instead of redeclaring it.
- `execute()` signatures narrowed to
  `InputCollectionInterface|InputInterface`.
- Null-valued keys count as existing for `get()` / `contains()` /
  `missing()`.
- Requirements: PHP `^8.3`, PHPUnit `^12`, PHPStan level `8`.

**Added:**

- `docs/` documentation and `UPGRADE.md`.
- `SKILL.md` agent skill.
- `Support\InputHelper` with a PHPStan assertion for collection
  narrowing.
- `format:check` composer script; CI matrix for PHP `8.3`/`8.4`.
- Regression tests for single-input `FilterAction::execute()`,
  null-key semantics, and `InputHelper`.
