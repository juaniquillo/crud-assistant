# AGENTS.md

- **PHP Version**: `^8.3` (PHP 8.3+ required).
- **Testing**: Run `composer test` (PHPUnit).
- **Static Analysis**: Run `composer analyse` (PHPStan).
- **Code Style**: Run `composer format` (PHP-CS-Fixer).
- **Quality Assurance**: Run `composer qa` to run analysis, formatting, and tests together.
- **Namespaces & Autoloading**: `Juaniquillo\CrudAssistant\` maps to `src/`, tests map to `Juaniquillo\CrudAssistant\Tests\` under `tests/`.
- **Conventions**:
  - Never silence PHPStan with `@phpstan-ignore`, baselines, asserts, or type-widening; fix the code instead.
  - Look recipes up via `getIdentifier()` (`$this->`/`static::`), never a class literal, inside or outside actions.
  - Attributes are the shared cross-action channel; per-action config belongs in that action's `Recipe`.
  - CI enforces `composer run format:check` (dry-run); `composer format` writes fixes locally.
