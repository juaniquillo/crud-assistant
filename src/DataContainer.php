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
 * @implements DataContainerInterface<TKey, TValue>
 */
final class DataContainer implements DataContainerInterface
{
    /** @use IsDataContainer<TKey, TValue> */
    use IsDataContainer;

    /**
     * @param array<TKey, TValue> $data
     */
    public static function make(array $data = []): static
    {
        return new static($data);
    }
}
