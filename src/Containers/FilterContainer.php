<?php

declare(strict_types=1);

namespace Juaniquillo\CrudAssistant\Containers;

use Juaniquillo\CrudAssistant\Concerns\IsDataContainer;
use Juaniquillo\CrudAssistant\Contracts\DataContainerInterface;

/**
 * @template TValue
 *
 * @implements DataContainerInterface<TValue>
 */
final class FilterContainer implements DataContainerInterface
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
