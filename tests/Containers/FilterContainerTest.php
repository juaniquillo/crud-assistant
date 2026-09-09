<?php

declare(strict_types=1);

namespace Juaniquillo\CrudAssistant\Tests\Containers;

use Juaniquillo\CrudAssistant\Containers\FilterContainer;
use PHPUnit\Framework\TestCase;

class FilterContainerTest extends TestCase
{
    public function testFilterContainerInitializationAndData(): void
    {
        $container = FilterContainer::make(['key1' => 'value1']);
        $this->assertEquals('value1', $container->get('key1'));
        $this->assertEquals('value1', $container['key1']);

        $container->set('key2', 'value2');
        $this->assertTrue(isset($container['key2']));

        unset($container['key2']);
        $this->assertFalse(isset($container['key2']));

        $this->assertCount(1, $container);
        $this->assertEquals(['key1' => 'value1'], $container->all());
    }
}
