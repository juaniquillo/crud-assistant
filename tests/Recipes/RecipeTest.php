<?php

declare(strict_types=1);

namespace Juaniquillo\CrudAssistant\Tests\Recipes;

use Juaniquillo\CrudAssistant\Actions\FilterAction;
use Juaniquillo\CrudAssistant\Actions\LabelValueAction;
use Juaniquillo\CrudAssistant\Inputs\TextInput;
use Juaniquillo\CrudAssistant\Recipes\FilterRecipe;
use Juaniquillo\CrudAssistant\Recipes\LabelValueRecipe;
use PHPUnit\Framework\TestCase;

class RecipeTest extends TestCase
{
    public function testLabelValueRecipe(): void
    {
        $recipe = LabelValueRecipe::make('Label', 'Value');
        $this->assertEquals(LabelValueAction::class, $recipe->getIdentifier());
        $this->assertEquals('Label', $recipe->label);
        $this->assertEquals('Value', $recipe->value);
    }

    public function testFilterRecipe(): void
    {
        $callback = static fn ($val) => $val;
        $recipe = FilterRecipe::make(true, true, $callback);
        $this->assertEquals(FilterAction::class, $recipe->getIdentifier());
        $this->assertTrue($recipe->filter);
        $this->assertTrue($recipe->ignoreIfEmpty);
        $this->assertEquals($callback, $recipe->callback);
    }

    public function testRecipeContainerOnInput(): void
    {
        $input = new TextInput('test');
        $recipe = LabelValueRecipe::make('L', 'V');

        $input->setRecipe($recipe);
        $this->assertNotNull($input->getRecipe(LabelValueAction::class));
        $this->assertEquals($recipe, $input->getRecipe(LabelValueAction::class));
    }
}
