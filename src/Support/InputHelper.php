<?php

declare(strict_types=1);

namespace Juaniquillo\CrudAssistant\Support;

use Juaniquillo\CrudAssistant\Contracts\InputCollectionInterface;
use Juaniquillo\CrudAssistant\Contracts\InputInterface;

/**
 * Input helpers.
 */
final class InputHelper
{
    public static function isCollection(InputInterface $input): bool
    {
        return $input instanceof InputCollectionInterface;
    }
}
