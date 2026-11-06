<?php

declare(strict_types=1);

namespace Juaniquillo\CrudAssistant;

use Juaniquillo\CrudAssistant\Concerns\IsAction;

/**
 * Action base class.
 */
abstract class Action
{
    use IsAction;
}
