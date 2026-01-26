<?php

declare(strict_types=1);

namespace Juaniquillo\CrudAssistant\Contracts;

interface ModifierInterface
{
    public function modify($value, $model = null);
}
