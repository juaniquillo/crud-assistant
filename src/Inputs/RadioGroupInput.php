<?php

declare(strict_types=1);

namespace Juaniquillo\CrudAssistant\Inputs;

use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Juaniquillo\CrudAssistant\Input;

/**
 * Radio group input class.
 */
class RadioGroupInput extends Input implements InputInterface
{
    /**
     * Input type.
     */
    protected ?string $type = 'radiogroup';
}
