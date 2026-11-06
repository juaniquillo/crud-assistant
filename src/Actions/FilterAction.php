<?php

declare(strict_types=1);

namespace Juaniquillo\CrudAssistant\Actions;

use Juaniquillo\CrudAssistant\Action;
use Juaniquillo\CrudAssistant\Containers\FilterContainer;
use Juaniquillo\CrudAssistant\Contracts\ActionInterface;
use Juaniquillo\CrudAssistant\Contracts\DataContainerInterface;
use Juaniquillo\CrudAssistant\Contracts\InputCollectionInterface;
use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Juaniquillo\CrudAssistant\Support\InputHelper;

/**
 * Filter action.
 */
final class FilterAction extends Action implements ActionInterface
{
    protected bool $controlsExecution = true;

    protected bool $controlsRecursion = true;

    /** @param array<int|string, mixed> $data */
    public function __construct(private array $data = [])
    {
        $this->output = new FilterContainer();
    }

    /** @param array<int|string, mixed> $data */
    public static function make(array $data = []): self
    {
        return new self($data);
    }

    public function prepare(): static
    {
        $this->output->set('data', $this->data);

        return $this;
    }

    public function execute(InputCollectionInterface|InputInterface|\IteratorAggregate $input): void
    {
        foreach ($input as $val) {
            $this->executeOne($val);
        }
    }

    /** @return DataContainerInterface<array-key, mixed> */
    public function executeOne(InputCollectionInterface|InputInterface|\IteratorAggregate $input): DataContainerInterface
    {
        if (InputHelper::isCollection($input) && $this->controlsRecursion) {
            foreach ($input as $val) {
                $this->executeOne($val);
            }
        }

        $output = $this->output;
        $data = $output->get('data');

        $name = $input->getName();
        $recipe = $input->getRecipe($this->getIdentifier());
        $value = $data[$name] ?? null;
        $ignoreIfEmpty = $recipe->ignoreIfEmpty ?? null;
        $callback = $recipe->callback ?? null;

        if ($ignoreIfEmpty && $this->isEmpty($value)) {
            unset($data[$name]);
        }

        if (\is_callable($callback)) {
            $data = $callback($input, $data);
        } elseif (isset($recipe->filter) && $recipe->filter) {
            unset($data[$name]);
        }

        $output->set('data', $data);

        return $output;
    }
}
