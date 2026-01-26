<?php

declare(strict_types=1);

namespace Juaniquillo\CrudAssistant\Inputs;

use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Juaniquillo\CrudAssistant\Input;

/**
 * Option input class.
 */
class OptionInput extends Input implements InputInterface
{
    /**
     * Input type.
     */
    protected ?string $type = 'option';
}
