<?php

declare(strict_types=1);

namespace Juaniquillo\CrudAssistant\Concerns;


/**
 * @template TKey of array-key
 * @template TValue
 */
trait IsDataContainer
{
    /** 
     * Bind the internal array to the template types.
     * @var array<TKey, TValue> 
     */
    protected array $data = [];

    /**
     * @param array<TKey, TValue> $data
     */
    public function __construct(array $data = [])
    {
        $this->fill($data);
    }

    /**
     * @throws \InvalidArgumentException
     * @return TValue
     */
    public function __get(string $name): mixed
    {
        if (!\array_key_exists($name, $this->data)) {
            throw new \InvalidArgumentException();
        }

        return $this->data[$name];
    }

    /**
     * @param TValue $value
     */
    public function __set(string $name, mixed $value): void
    {
        /** @var TKey $name */
        /** @phpstan-ignore varTag.nativeType */
        $this->data[$name] = $value;
    }

    public function __isset(string $name): bool
    {
        return isset($this->data[$name]);
    }

    public function __unset(string $name): void
    {
        unset($this->data[$name]);
    }

    public function __toString(): string
    {
        return json_encode($this->data) ?: '{}';
    }

    /**
     * @param TKey $name
     * @return TValue
     * @throws \InvalidArgumentException
     */
    public function get(mixed $name): mixed
    {
        if (!isset($this->data[$name])) {
            throw new \InvalidArgumentException();
        }

        return $this->data[$name];
    }

    /**
     * @param TKey $name
     * @param TValue $value
     */
    public function set(mixed $name, mixed $value): static
    {
        $this->data[$name] = $value;

        return $this;
    }

    /**
     * @param array<TKey, TValue> $data
     */
    public function fill(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param array<TKey, TValue> $data
     */
    public function add(array $data): static
    {
        $this->data = array_merge($this->data, $data);

        return $this;
    }

    /**
     * @param TValue $value
     */
    public function push(mixed $value): static
    {
        $this->data[] = $value;

        return $this;
    }

    /**
     * @param array<int, TKey> $keys
     */
    public function contains(array $keys): bool
    {
        foreach ($keys as $key) {
            if (!isset($this->data[$key])) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param array<int, TKey> $keys
     * @return TKey|false
     */
    public function missing(array $keys): mixed
    {
        foreach ($keys as $key) {
            if (!isset($this->data[$key])) {
                return $key;
            }
        }

        return false;
    }

    /**
     * @return array<TKey, TValue>
     */
    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * @return array<TKey, TValue>
     */
    public function all(): array
    {
        return $this->toArray();
    }

    /**
     * @return \ArrayIterator<TKey, TValue>
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->data);
    }

    public function count(): int
    {
        return \count($this->data);
    }

    /**
     * @param TKey|null $offset
     * @param TValue $value
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if ($offset === null) {
            $this->data[] = $value;
        } else {
            $this->data[$offset] = $value;
        }
    }

    /**
     * @param TKey $offset
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->data[$offset]);
    }

    /**
     * @param TKey $offset
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->data[$offset]);
    }

    /**
     * @param TKey $offset
     * @return TValue
     * @throws \InvalidArgumentException
     */
    public function offsetGet(mixed $offset): mixed
    {
        if (!\array_key_exists($offset, $this->data)) {
            throw new \InvalidArgumentException();
        }

        return $this->data[$offset];
    }
}
