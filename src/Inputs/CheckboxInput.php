<?php

declare(strict_types=1);

namespace Juaniquillo\CrudAssistant\Inputs;

use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Juaniquillo\CrudAssistant\Input;

/**
 * Checkbox input class.
 */
class CheckboxInput extends Input implements InputInterface
{
    /**
     * Input type.
     */
    protected ?string $type = 'checkbox';
}
