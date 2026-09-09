<?php

declare(strict_types=1);

namespace Juaniquillo\CrudAssistant\Actions;

use Juaniquillo\CrudAssistant\Action;
use Juaniquillo\CrudAssistant\Contracts\ActionInterface;
use Juaniquillo\CrudAssistant\Contracts\InputCollectionInterface;
use Juaniquillo\CrudAssistant\Contracts\InputInterface;

class PrepareCleanupAction extends Action implements ActionInterface
{
    public function prepare(): static
    {
        $output = $this->getOutput();

        $output->set('prepare', 1);

        return parent::prepare();
    }

    public function execute(InputCollectionInterface|InputInterface|\IteratorAggregate $input)
    {
        $output = $this->getOutput();

        $output->{$input->getName()} = $input->getLabel();

        return $output;
    }

    public function cleanup(): static
    {
        $output = $this->getOutput();

        $output->set('cleanup', 1);

        return parent::cleanup();
    }
}
