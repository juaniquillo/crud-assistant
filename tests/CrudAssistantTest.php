<?php

declare(strict_types=1);

namespace Juaniquillo\CrudAssistant\Tests;

use Juaniquillo\CrudAssistant\Contracts\InputCollectionInterface;
use Juaniquillo\CrudAssistant\CrudAssistant;
use Juaniquillo\CrudAssistant\Inputs\TextInput;
use PHPUnit\Framework\TestCase;

class CrudAssistantTest extends TestCase
{
    public function testWhenTheMakeMethodIsCalledOnCrudAssistantAnInputCollectionInstanceIsReturned(): void
    {
        $manager = CrudAssistant::make([]);

        $this->assertInstanceOf(InputCollectionInterface::class, $manager);
    }

    public function testAnArrayOfInputsInstancesCanBePassedToTheConstructor(): void
    {
        $inputs = [
            new TextInput('name'),
            new TextInput('email'),
        ];

        $manager = new CrudAssistant($inputs);

        $this->assertEquals(2, $manager->getCollection()->count());
    }
}
