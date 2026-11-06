<?php

declare(strict_types=1);

namespace Juaniquillo\CrudAssistant\Concerns;

/**
 * @template TValue
 */
trait IsDataContainer
{
    /**
     * Bind the internal array to the template type.
     *
     * @var array<array-key, TValue>
     */
    protected array $data = [];

    /**
     * @param array<array-key, TValue> $data
     */
    public function __construct(array $data = [])
    {
        $this->fill($data);
    }

    /**
     * @throws \InvalidArgumentException
     *
     * @return TValue
     */
    public function __get(string $name): mixed
    {
        if (!\array_key_exists($name, $this->data)) {
            throw new \InvalidArgumentException("The {$name} key does not exist in the container.");
        }

        return $this->data[$name];
    }

    /**
     * @param TValue $value
     */
    public function __set(string $name, mixed $value): void
    {
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
     * @param array-key $name
     *
     * @throws \InvalidArgumentException
     *
     * @return TValue
     */
    public function get(mixed $name): mixed
    {
        if (!\array_key_exists($name, $this->data)) {
            throw new \InvalidArgumentException("The {$name} key does not exist in the container.");
        }

        return $this->data[$name];
    }

    /**
     * @param array-key $name
     * @param TValue    $value
     */
    public function set(mixed $name, mixed $value): static
    {
        $this->data[$name] = $value;

        return $this;
    }

    /**
     * @param array<array-key, TValue> $data
     */
    public function fill(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param array<array-key, TValue> $data
     */
    public function merge(array $data): static
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
     * @param array<int, array-key> $keys
     */
    public function contains(array $keys): bool
    {
        foreach ($keys as $key) {
            if (!\array_key_exists($key, $this->data)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param array<int, array-key> $keys
     *
     * @return array-key|false
     */
    public function missing(array $keys): mixed
    {
        foreach ($keys as $key) {
            if (!\array_key_exists($key, $this->data)) {
                return $key;
            }
        }

        return false;
    }

    /**
     * @return array<array-key, TValue>
     */
    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * @return array<array-key, TValue>
     */
    public function all(): array
    {
        return $this->toArray();
    }

    /**
     * @return \ArrayIterator<array-key, TValue>
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
     * @param array-key|null $offset
     * @param TValue         $value
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
     * @param array-key $offset
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->data[$offset]);
    }

    /**
     * @param array-key $offset
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->data[$offset]);
    }

    /**
     * @param array-key $offset
     *
     * @throws \InvalidArgumentException
     *
     * @return TValue
     */
    public function offsetGet(mixed $offset): mixed
    {
        if (!\array_key_exists($offset, $this->data)) {
            throw new \InvalidArgumentException("The {$offset} key does not exist in the container.");
        }

        return $this->data[$offset];
    }
}
