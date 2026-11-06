<?php

declare(strict_types=1);

namespace Juaniquillo\CrudAssistant;

use Juaniquillo\CrudAssistant\Contracts\ActionInterface;
use Juaniquillo\CrudAssistant\Contracts\DataContainerInterface;
use Juaniquillo\CrudAssistant\Contracts\InputCollectionInterface;
use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Juaniquillo\CrudAssistant\Contracts\RecipeInterface;

/**
 * Input Base Class.
 */
abstract class Input implements InputInterface
{
    protected ?string $name = null;

    protected ?string $label = null;

    protected ?int $version = 1;

    /** @var array<string, int|string> */
    protected array $attributes = [];

    protected ?InputCollectionInterface $subElements = null;

    protected ?string $type = null;

    protected bool $prepare = true;

    protected bool $cleanup = true;

    /** @var array<int|string, RecipeInterface> */
    protected array $recipes = [];

    /** @var array<int|string, class-string<ActionInterface>> */
    protected array $onlyFor = [];

    public function __construct(?string $name = null, ?string $label = null)
    {
        $this->name = $name;
        $this->label = $label ?? $name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function setAttribute(string $name, int|string $value): static
    {
        $this->attributes[$name] = $value;

        return $this;
    }

    public function setSubElements(InputCollectionInterface $subElements): static
    {
        $this->subElements = $subElements;

        return $this;
    }

    public function setVersion(int $version): static
    {
        $this->version = $version;

        return $this;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function disablePrepare(): static
    {
        $this->prepare = false;

        return $this;
    }

    public function disableCleanup(): static
    {
        $this->cleanup = false;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getAttribute(string $name): mixed
    {
        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        }

        return null;
    }

    /** @return array<string, int|string> */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function unsetAttribute(string $key): static
    {
        if (isset($this->attributes[$key])) {
            unset($this->attributes[$key]);
        }

        return $this;
    }

    /** @param array<int|string, class-string<ActionInterface>> $actions */
    public function onlyFor(array $actions): static
    {
        $this->onlyFor = $actions;

        return $this;
    }

    /** @return array<int|string, class-string<ActionInterface>> */
    public function getOnlyFor(): array
    {
        return $this->onlyFor;
    }

    public function isFor(string $action): bool
    {
        if (empty($this->getOnlyFor())) {
            return true;
        }

        return \in_array($action, $this->onlyFor);
    }

    public function getSubElements(): ?InputCollectionInterface
    {
        return $this->subElements;
    }

    public function setRecipe(RecipeInterface $recipe): static
    {
        $this->recipes[$recipe->getIdentifier()] = $recipe;

        return $this;
    }

    public function getRecipe(string $recipe): ?RecipeInterface
    {
        if (isset($this->recipes[$recipe])) {
            return $this->recipes[$recipe];
        }

        return null;
    }

    /** @return array<int|string, RecipeInterface> */
    public function getRecipes(): array
    {
        return $this->recipes;
    }

    /** @return DataContainerInterface<array-key, mixed> */
    public function execute(ActionInterface $action): DataContainerInterface
    {
        $action->execute($this);

        return $action->getOutput();
    }
}
