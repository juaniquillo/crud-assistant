<?php

declare(strict_types=1);

namespace Juaniquillo\CrudAssistant\Contracts;

/**
 * @template TKey of array-key
 * @template TValue
 *
 * @extends \IteratorAggregate<TKey, TValue>
 * @extends \ArrayAccess<TKey, TValue>
 */
interface DataContainerInterface extends \IteratorAggregate, \Countable, \ArrayAccess
{
    /**
     * @param TKey $name
     *
     * @throws \InvalidArgumentException
     *
     * @return TValue
     */
    public function get(mixed $name): mixed;

    /**
     * @param TKey   $name
     * @param TValue $value
     */
    public function set(mixed $name, mixed $value): static;

    /** @param array<TKey, TValue> $data */
    public function fill(array $data): static;

    /** @param array<TKey, TValue> $data */
    public function merge(array $data): static;

    /** @param TValue $value */
    public function push(mixed $value): static;

    /** @param array<int, TKey> $keys */
    public function contains(array $keys): bool;

    /**
     * @param array<int, TKey> $keys
     *
     * @return false|TKey
     */
    public function missing(array $keys): mixed;

    /** @return array<TKey, TValue> */
    public function toArray(): array;

    /** @return array<TKey, TValue> */
    public function all(): array;
}
