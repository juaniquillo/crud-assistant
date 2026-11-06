<?php

declare(strict_types=1);

namespace Juaniquillo\CrudAssistant;

use Juaniquillo\CrudAssistant\Concerns\IsDataContainer;
use Juaniquillo\CrudAssistant\Contracts\DataContainerInterface;

/**
 * DataContainer.
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @implements \ArrayAccess<TKey, TValue>
 * @implements \IteratorAggregate<TKey, TValue>
 */
#[\AllowDynamicProperties]
final class DataContainer implements DataContainerInterface, \IteratorAggregate, \Countable, \ArrayAccess
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
