<?php

declare(strict_types=1);

namespace Juaniquillo\CrudAssistant\Recipes;

use Juaniquillo\CrudAssistant\Actions\LabelValueAction;
use Juaniquillo\CrudAssistant\Concerns\IsRecipe;
use Juaniquillo\CrudAssistant\Contracts\RecipeInterface;

/**
 * Label Value Action Recipe.
 */
final class LabelValueRecipe implements RecipeInterface
{
    use IsRecipe;

    /**
     * @param class-string $action
     */
    protected ?string $action = LabelValueAction::class;

    public function __construct(
        public readonly \Closure|string|null $label = null,
        public readonly \Closure|string|null $value = null,
    ) {
    }

    public static function make(?string $label = null, $value = null): self
    {
        return new self($label, $value);
    }
}
