<?php

declare(strict_types=1);

namespace Juaniquillo\CrudAssistant;

use Juaniquillo\CrudAssistant\Concerns\IsDataContainer;
use Juaniquillo\CrudAssistant\Contracts\DataContainerInterface;

/**
 * DataContainer.
 *
 * @template TValue
 *
 * @implements DataContainerInterface<TValue>
 */
final class DataContainer implements DataContainerInterface
{
    /** @use IsDataContainer<TValue> */
    use IsDataContainer;

    /**
     * @param array<array-key, TValue> $data
     */
    public static function make(array $data = []): static
    {
        return new static($data);
    }
}
