<?php

declare(strict_types=1);

namespace Juaniquillo\CrudAssistant\Tests\Support;

use Juaniquillo\CrudAssistant\InputCollection;
use Juaniquillo\CrudAssistant\Inputs\TextInput;
use Juaniquillo\CrudAssistant\Support\InputHelper;
use PHPUnit\Framework\TestCase;

class InputHelperTest extends TestCase
{
    public function testIsCollectionReturnsTrueForInputCollections(): void
    {
        $this->assertTrue(InputHelper::isCollection(new InputCollection()));
    }

    public function testIsCollectionReturnsFalseForPlainInputs(): void
    {
        $this->assertFalse(InputHelper::isCollection(new TextInput('name')));
    }
}
