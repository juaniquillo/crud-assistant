<?php

declare(strict_types=1);

namespace Juaniquillo\CrudAssistant\Containers;

use Juaniquillo\CrudAssistant\Concerns\IsDataContainer;
use Juaniquillo\CrudAssistant\Contracts\DataContainerInterface;

/**
 * @template TKey of array-key
 * @template TValue
 *
 * @implements \ArrayAccess<TKey, TValue>
 * @implements \IteratorAggregate<TKey, TValue>
 */
final class FilterContainer implements \ArrayAccess, \Countable, DataContainerInterface, \IteratorAggregate
{
    /** @use IsDataContainer<TKey, TValue> */
    use IsDataContainer;

    /**
     * @param array<TKey, TValue> $data
     */
    public static function make(array $data = []): DataContainerInterface
    {
        return new static($data);
    }
}
