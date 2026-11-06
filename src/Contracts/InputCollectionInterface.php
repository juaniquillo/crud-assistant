<?php

declare(strict_types=1);

namespace Juaniquillo\CrudAssistant\Contracts;

/**
 * Input Collection Interface.
 *
 * @extends \IteratorAggregate<array-key, InputInterface>
 */
interface InputCollectionInterface extends InputInterface, \IteratorAggregate
{
    /** @param array<int|string, InputInterface> $inputsArray */
    public function setInputs(array $inputsArray): static;

    public function addInput(InputInterface $input, ?string $key = null): static;

    public function removeInput(string $key): static;

    /** @param array<int|string, string> $partialCollection */
    public function setPartialCollection(array $partialCollection): static;

    /** @return array<int|string, InputInterface> */
    public function getPartialCollection(): array;

    public function count(): int;

    public function has(string $key): bool;

    public function getInput(string $key): InputInterface;

    /** @return array<int|string, InputInterface> */
    public function getInputs(bool $all = false): array;
    
    /** @return array<int|string, string> */
    public function getInputNames(): array;

    /** @return array<int|string, string> */
    public function getInputLabels(): array;

    public function executeAll(ActionInterface $action): void;
}
