<?php

declare(strict_types=1);

namespace Juaniquillo\CrudAssistant\Tests\Inputs;

use Juaniquillo\CrudAssistant\Actions\FilterAction;
use Juaniquillo\CrudAssistant\Actions\LabelValueAction;
use Juaniquillo\CrudAssistant\Actions\PrepareCleanupAction;
use Juaniquillo\CrudAssistant\Inputs\CheckboxInput;
use Juaniquillo\CrudAssistant\Inputs\DefaultInput;
use Juaniquillo\CrudAssistant\Inputs\FileInput;
use Juaniquillo\CrudAssistant\Inputs\OptionInput;
use Juaniquillo\CrudAssistant\Inputs\RadioGroupInput;
use Juaniquillo\CrudAssistant\Inputs\RadioInput;
use Juaniquillo\CrudAssistant\Inputs\SelectInput;
use Juaniquillo\CrudAssistant\Inputs\TextareaInput;
use Juaniquillo\CrudAssistant\Inputs\TextInput;
use PHPUnit\Framework\TestCase;

class InputTypesTest extends TestCase
{
    public function testInputSubclasses(): void
    {
        $this->assertInstanceOf(TextInput::class, new TextInput('name'));
        $this->assertInstanceOf(TextareaInput::class, new TextareaInput('name'));
        $this->assertInstanceOf(SelectInput::class, new SelectInput('name'));
        $this->assertInstanceOf(CheckboxInput::class, new CheckboxInput('name'));
        $this->assertInstanceOf(FileInput::class, new FileInput('name'));
        $this->assertInstanceOf(RadioInput::class, new RadioInput('name'));
        $this->assertInstanceOf(RadioGroupInput::class, new RadioGroupInput('name'));
        $this->assertInstanceOf(OptionInput::class, new OptionInput('value', 'label'));
        $this->assertInstanceOf(DefaultInput::class, new DefaultInput('name'));
    }

    public function testOnlyForFunctionality(): void
    {
        $input = new TextInput('username');
        $actionA = LabelValueAction::make(new \stdClass());
        $actionB = FilterAction::make();

        // Default: available for any action
        $this->assertTrue($input->isFor($actionA->getIdentifier()));
        $this->assertEquals([], $input->getOnlyFor());

        // Restrict to specific actions
        $input->onlyFor([$actionA->getIdentifier(), $actionB->getIdentifier()]);
        $this->assertEquals([$actionA->getIdentifier(), $actionB->getIdentifier()], $input->getOnlyFor());
        $this->assertTrue($input->isFor($actionA->getIdentifier()));
        $this->assertTrue($input->isFor($actionB->getIdentifier()));
        $this->assertFalse($input->isFor(PrepareCleanupAction::getIdentifier()));
    }
}
