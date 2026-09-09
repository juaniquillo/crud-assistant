<?php

declare(strict_types=1);

namespace Juaniquillo\CrudAssistant\Tests\Actions;

use Juaniquillo\CrudAssistant\Actions\PrepareCleanupAction;
use Juaniquillo\CrudAssistant\DataContainer;
use Juaniquillo\CrudAssistant\Inputs\TextInput;
use PHPUnit\Framework\TestCase;

class PrepareCleanupActionTest extends TestCase
{
    public function testPrepareAndCleanup(): void
    {
        $action = new PrepareCleanupAction();
        $output = new DataContainer();
        // action uses getOutput() which initializes output if null
        $action->prepare();
        $this->assertEquals(1, $action->getOutput()->get('prepare') ?? 0);

        $input = new TextInput('test', 'Test Label');
        $result = $action->execute($input);
        $this->assertEquals('Test Label', $result->test);

        $action->cleanup();
        // Since cleanup() just returns $this, let's test output handling or custom action subclassing if needed.
        $this->assertInstanceOf(PrepareCleanupAction::class, $action->cleanup());
    }
}
