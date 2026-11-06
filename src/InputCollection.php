<?php

declare(strict_types=1);

namespace Juaniquillo\CrudAssistant;

use Juaniquillo\CrudAssistant\Contracts\ActionInterface;
use Juaniquillo\CrudAssistant\Contracts\DataContainerInterface;
use Juaniquillo\CrudAssistant\Contracts\InputCollectionInterface;
use Juaniquillo\CrudAssistant\Contracts\InputInterface;

/**
 * Input Collection Class.
 *
 * @implements \IteratorAggregate<array-key, InputInterface>
 */
class InputCollection extends Input implements InputInterface, InputCollectionInterface, \IteratorAggregate, \Countable
{
    /** @var InputInterface[] */
    protected array $inputsArray = [];

    /** @var InputInterface[] */
    protected array $partialCollection = [];

    public function setInputs(array $inputsArray): static
    {
        foreach ($inputsArray as $input) {
            $this->addInput($input);
        }

        return $this;
    }

    public function addInput(InputInterface $input, ?string $key = null): static
    {
        $key ??= $input->getName();

        $this->inputsArray[$key] = $input;

        return $this;
    }

    public function removeInput(string $key): static
    {
        if (isset($this->inputsArray[$key])) {
            unset($this->inputsArray[$key]);
        }
        if (isset($this->partialCollection[$key])) {
            unset($this->partialCollection[$key]);
        }

        return $this;
    }

    /** @param array<int|string, string> $partialCollection */
    public function setPartialCollection(array $partialCollection): static
    {
        if (!\count($partialCollection)) {
            throw new \Exception('The array passed is empty', 500);
        }

        $inputs = $this->getInputs();

        if (!\count($inputs)) {
            throw new \Exception('This collection cannot add partial inputs because it has no inputs', 500);
        }

        foreach ($partialCollection as $inputName) {
            $this->partialCollection[$inputName] = $this->getInput($inputName);
        }

        return $this;
    }

    public function getPartialCollection(): array
    {
        return $this->partialCollection;
    }

    public function count(): int
    {
        return \count($this->getInputs());
    }

    public function isset(string $key): bool
    {
        return isset($this->inputsArray[$key]);
    }

    public function getInput(string $key): InputInterface
    {
        if (isset($this->inputsArray[$key])) {
            return $this->inputsArray[$key];
        }

        throw new \InvalidArgumentException("The {$key} Input has not been registered or does not exist", 500);
    }

    /**
     * Returns inputs array.
     * If partial inputs have been set
     * it returns partial inputs.
     */
    public function getInputs(bool $all = false): array
    {
        $partialCollection = $this->getPartialCollection();

        if (\count($partialCollection) && !$all) {
            return $partialCollection;
        }

        return $this->inputsArray;
    }

    public function getInputNames(): array
    {
        $names = [];

        foreach ($this->getInputs() as $input) {
            $names[] = $input->getName();
        }

        return $names;
    }

    public function getInputLabels(): array
    {
        $labels = [];

        foreach ($this->getInputs() as $input) {
            $labels[] = $input->getLabel();
        }

        return $labels;
    }

    public function execute(ActionInterface $action): DataContainerInterface
    {
        if ($action->controlsExecution()) {
            $this->executeAll($action);

            return $action->getOutput();
        }

        if ($this->prepare) {
            $action->prepare();
        }

        $identifier = $action->getIdentifier();

        foreach ($this->getInputs() as $input) {
            $recipe = $input->getRecipe($identifier);

            if ($recipe && $recipe->isIgnored()) {
                continue;
            }

            if (!$input->isFor($identifier)) {
                continue;
            }

            if (CrudAssistant::isInputCollection($input) && $action->controlsRecursion()) {
                $action->execute($input);

                continue;
            }

            if (CrudAssistant::isInputCollection($input)) {
                $input->disablePrepare()
                    ->disableCleanup();

                $input->execute($action);

                if ($action->processInternalCollection()) {
                    $action->execute($input);
                }

                continue;
            }

            $input->execute($action);
        }

        if ($this->cleanup) {
            $action->cleanup();
        }

        return $action->getOutput();

    }

    public function executeAll(ActionInterface $action): void
    {
        $action->prepare();
        $action->execute($this);
        $action->cleanup();

    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->getInputs());
    }
}
