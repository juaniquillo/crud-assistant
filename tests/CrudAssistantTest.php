<?php

declare(strict_types=1);

namespace Juaniquillo\CrudAssistant\Tests;

use Juaniquillo\CrudAssistant\Contracts\InputCollectionInterface;
use Juaniquillo\CrudAssistant\CrudAssistant;
use Juaniquillo\CrudAssistant\InputCollection;
use Juaniquillo\CrudAssistant\Inputs\TextInput;
use PHPUnit\Framework\TestCase;

class CrudAssistantTest extends TestCase
{
    public function testWhenTheMakeMethodIsCalledOnCrudAssistantAnInputCollectionInstanceIsReturned()
    {
        $manager = CrudAssistant::make([]);

        $this->assertInstanceOf(InputCollectionInterface::class, $manager);
    }

    public function testAnArrayOfInputsInstancesCanBePassedToTheConstructor()
    {
        $inputs = [
            new TextInput('name'),
            new TextInput('email'),
        ];

        $manager = new CrudAssistant($inputs);

        $this->assertEquals(2, $manager->getCollection()->count());
    }

    public function testTheIsInputCollectionHelperChecksIfParameterIsAnInputCollection()
    {
        $this->assertTrue(CrudAssistant::isInputCollection(new InputCollection()));

        $this->assertFalse(CrudAssistant::isInputCollection(new TextInput()));
    }

    public function testTheIsClosureHelperChecksIfParameterIsAClosure()
    {
        $this->assertTrue(CrudAssistant::isClosure(static function () {}));

        $this->assertFalse(CrudAssistant::isClosure('array_map'));
    }
}
