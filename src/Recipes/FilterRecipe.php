<?php

declare(strict_types=1);

namespace Juaniquillo\CrudAssistant\Recipes;

use Juaniquillo\CrudAssistant\Actions\FilterAction;
use Juaniquillo\CrudAssistant\Concerns\IsRecipe;
use Juaniquillo\CrudAssistant\Contracts\RecipeInterface;

/**
 * Filter Action Recipe.
 */
final class FilterRecipe implements RecipeInterface
{
    use IsRecipe;

    /**
     * @param class-string $action
     */
    protected ?string $action = FilterAction::class;

    public function __construct(
        public readonly bool $filter = true,
        public readonly bool $ignoreIfEmpty = false,
        public readonly ?\Closure $callback = null,
    ) {
    }

    public static function make(bool $filter = true, bool $ignoreIfEmpty = false, ?\Closure $callback = null): self
    {
        return new self(
            $filter,
            $ignoreIfEmpty,
            $callback
        );
    }
}
