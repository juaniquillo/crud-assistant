<?php

declare(strict_types=1);

namespace Juaniquillo\CrudAssistant;

use Juaniquillo\CrudAssistant\Concerns\IsRecipe;
use Juaniquillo\CrudAssistant\Contracts\RecipeInterface;

/**
 * the recipe class stores input
 * information and instructions
 * for the action.
 */
abstract class RecipeContainer implements RecipeInterface
{
    use IsRecipe;
}
