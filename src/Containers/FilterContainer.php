<?php

declare(strict_types=1);

namespace Juaniquillo\CrudAssistant\Containers;

use Juaniquillo\CrudAssistant\Concerns\IsDataContainer;
use Juaniquillo\CrudAssistant\Contracts\DataContainerInterface;

final class FilterContainer implements \ArrayAccess, \Countable, DataContainerInterface, \IteratorAggregate
{
    use IsDataContainer;

    public static function make(array $data = []): DataContainerInterface
    {
        return new static($data);
    }
}
