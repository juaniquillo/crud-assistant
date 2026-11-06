<?php

declare(strict_types=1);

namespace Juaniquillo\CrudAssistant\Contracts;

/**
 * @template TValue
 *
 * @extends \IteratorAggregate<array-key, TValue>
 * @extends \ArrayAccess<array-key, TValue>
 */
interface DataContainerInterface extends \IteratorAggregate, \Countable, \ArrayAccess
{
    /**
     * @param array-key $name
     *
     * @throws \InvalidArgumentException
     *
     * @return TValue
     */
    public function get(mixed $name): mixed;

    /**
     * @param array-key $name
     * @param TValue    $value
     */
    public function set(mixed $name, mixed $value): static;

    /** @param array<array-key, TValue> $data */
    public function fill(array $data): static;

    /** @param array<array-key, TValue> $data */
    public function merge(array $data): static;

    /** @param TValue $value */
    public function push(mixed $value): static;

    /** @param array<int, array-key> $keys */
    public function contains(array $keys): bool;

    /**
     * @param array<int, array-key> $keys
     *
     * @return array-key|false
     */
    public function missing(array $keys): mixed;

    /** @return array<array-key, TValue> */
    public function toArray(): array;

    /** @return array<array-key, TValue> */
    public function all(): array;
}
