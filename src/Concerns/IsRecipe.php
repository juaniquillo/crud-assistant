<?php

declare(strict_types=1);

namespace Juaniquillo\CrudAssistant\Concerns;

use Juaniquillo\CrudAssistant\Contracts\ModifierInterface;

/**
 * Recipe Trait.
 */
trait IsRecipe
{
    // protected ?string $action = null;

    protected bool $ignored = false;

    /** @var array<int, ModifierInterface> */
    protected array $modifiers = [];

    public function getIdentifier(): string
    {
        $action = $this->action ?? null;
        if (isset($this->action)) {
            return $action::getIdentifier();
        }

        return static::class;
    }

    public function ignore(bool $ignore = true): static
    {
        $this->ignored = $ignore;

        return $this;
    }

    public function setModifier(ModifierInterface $modifier): static
    {
        $this->modifiers[] = $modifier;

        return $this;
    }

    /** @param array<int, ModifierInterface> $modifiers */
    public function setModifiers(array $modifiers): static
    {
        foreach ($modifiers as $modifier) {
            $this->setModifier($modifier);
        }

        return $this;
    }

    /** @return array<int, ModifierInterface> */
    public function getModifiers(): array
    {
        return $this->modifiers;
    }

    public function hasModifiers(): bool
    {
        return (bool) \count($this->getModifiers());
    }

    public function isIgnored(): bool
    {
        return $this->ignored;
    }
}
