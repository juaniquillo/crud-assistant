<?php

declare(strict_types=1);

namespace Juaniquillo\CrudAssistant\Contracts;

/**
 * Recipe Interface.
 */
interface RecipeInterface
{
    public function getIdentifier(): string;

    public function ignore(bool $ignore = true): static;

    public function setModifier(ModifierInterface $modifier): static;

    /** @param array<int, ModifierInterface> $modifiers */
    public function setModifiers(array $modifiers): static;

    /** @return array<int, ModifierInterface> */
    public function getModifiers(): array;

    public function hasModifiers(): bool;

    public function isIgnored(): bool;
}
