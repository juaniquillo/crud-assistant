<?php

declare(strict_types=1);

namespace Juaniquillo\CrudAssistant\Concerns;

use Juaniquillo\CrudAssistant\Contracts\DataContainerInterface;
use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Juaniquillo\CrudAssistant\Contracts\ModifierInterface;
use Juaniquillo\CrudAssistant\DataContainer;

trait IsAction
{
    /** @var DataContainerInterface<array-key, mixed>|null */
    protected ?DataContainerInterface $output = null;

    /**
     * See ActionInterface::controlsRecursion().
     */
    protected bool $controlsRecursion = false;

    /**
     * See ActionInterface::controlsExecution().
     */
    protected bool $controlsExecution = false;

    /**
     * See ActionInterface::processInternalCollection().
     */
    protected bool $processInternalCollection = false;

    public function initOutput(): static
    {
        if (!$this->output) {
            $this->output = new DataContainer();
        }

        return $this;
    }

    public static function getIdentifier(): string
    {
        return static::class;
    }

    public function setControlsRecursion(bool $controlsRecursion): static
    {
        $this->controlsRecursion = $controlsRecursion;

        return $this;
    }

    public function setProcessInternalCollection(bool $processInternalCollection): static
    {
        $this->processInternalCollection = $processInternalCollection;

        return $this;
    }

    public function prepare(): static
    {
        return $this;
    }

    public function cleanup(): static
    {
        return $this;
    }

    public function controlsRecursion(): bool
    {
        return $this->controlsRecursion;
    }

    public function controlsExecution(): bool
    {
        return $this->controlsExecution;
    }

    public function processInternalCollection(): bool
    {
        return $this->processInternalCollection;
    }

    public function isEmpty(mixed $value): bool
    {
        return $value === '' || $value === null;
    }

    /** @return DataContainerInterface<array-key, mixed> */
    public function getOutput(): DataContainer|DataContainerInterface
    {
        $this->initOutput();

        return $this->output;
    }

    protected function modifiers(mixed $value, InputInterface $input, ?object $model = null): mixed
    {
        $recipe = $input->getRecipe(static::class);

        if (!$recipe) {
            return $value;
        }

        $modifiers = $recipe->getModifiers();

        foreach ($modifiers as $modifier) {
            $value = $this->executeModifier($modifier, $value, $model);
        }

        return $value;
    }

    protected function executeModifier(ModifierInterface $modifier, mixed $value, ?object $model = null): mixed
    {
        return $modifier->modify($value, $model);
    }
}
