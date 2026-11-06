<?php

declare(strict_types=1);

namespace Juaniquillo\CrudAssistant\Contracts;

interface DataContainerInterface
{
    public function get(string $name): mixed;

    public function set(string $name, mixed $value): static;

    /** @param array<array-key, mixed> $data */
    public function fill(array $data): static;

    /** @param array<array-key, mixed> $data */
    public function merge(array $data): static;

    public function push(mixed $value): static;
    
    /** @param array<array-key, mixed> $keys */
    public function contains(array $keys): bool;

    /** @param array<array-key, mixed> $keys */
    public function missing(array $keys): mixed;

    /** @return array<array-key, mixed> */
    public function toArray(): array;

    /** @return array<array-key, mixed> */
    public function all(): array;
}
