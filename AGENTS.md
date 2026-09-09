# AGENTS.md

- **PHP Version**: `^8.2` (PHP 8.2+ required).
- **Testing**: Run `composer test` (PHPUnit).
- **Static Analysis**: Run `composer analyse` (PHPStan).
- **Code Style**: Run `composer format` (PHP-CS-Fixer).
- **Quality Assurance**: Run `composer qa` to run analysis, formatting, and tests together.
- **Namespaces & Autoloading**: `Juaniquillo\CrudAssistant\` maps to `src/`, tests map to `Juaniquillo\CrudAssistant\Tests\` under `tests/`. Helper functions are included via `helpers/helpers.php`.
