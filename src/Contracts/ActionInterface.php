<?php

declare(strict_types=1);

namespace Juaniquillo\CrudAssistant\Contracts;

/**
 * Action Interface.
 */
interface ActionInterface
{
    public function initOutput(): static;

    public static function getIdentifier(): string;

    public function setProcessInternalCollection(bool $processInternalCollection): static;

    public function prepare(): static;

    /**
     * Run the action against a single input or a collection of inputs.
     */
    public function execute(InputCollectionInterface|InputInterface $input): void;

    public function cleanup(): static;

    /**
     * When true, the action drives iteration itself via executeAll().
     * InputCollection::execute() runs executeAll() and returns early
     * without its own per-input loop.
     */
    public function controlsExecution(): bool;

    /**
     * When true, nested collections are handed to the action as a whole
     * ($action->execute($collection)) so it can recurse internally
     * instead of InputCollection iterating the members.
     */
    public function controlsRecursion(): bool;

    /**
     * When true, InputCollection additionally runs the action against a
     * nested collection itself after running it against each member.
     */
    public function processInternalCollection(): bool;

    /** @return DataContainerInterface<mixed> */
    public function getOutput(): DataContainerInterface;
}
