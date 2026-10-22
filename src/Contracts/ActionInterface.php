<?php

declare(strict_types=1);

namespace Juaniquillo\CrudAssistant\Contracts;

use Juaniquillo\CrudAssistant\InputCollection;

/**
 * Action Interface.
 */
interface ActionInterface
{
    public function initOutput(): static;

    public static function getIdentifier(): string;

    public function setProcessInternalCollection(bool $processInternalCollection): static;

    public function prepare(): static;

    public function execute(InputCollection|InputInterface|\IteratorAggregate $input): void;

    public function cleanup(): static;

    public function controlsRecursion(): bool;

    public function controlsExecution(): bool;

    public function processInternalCollection(): bool;

    public function getOutput(): DataContainerInterface;
}
