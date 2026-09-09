<?php

declare(strict_types=1);

namespace Juaniquillo\CrudAssistant\Inputs;

use Juaniquillo\CrudAssistant\Contracts\InputInterface;
use Juaniquillo\CrudAssistant\Input;

/**
 * File input class.
 */
class FileInput extends Input implements InputInterface
{
    /**
     * Input type.
     */
    protected ?string $type = 'file';
}
