<?php

declare(strict_types=1);

namespace Juaniquillo\CrudAssistant\Modifiers;

use Juaniquillo\CrudAssistant\Contracts\ModifierInterface;

class BooleanModifier implements ModifierInterface
{
    public function __construct(
        private string $trueLabel = 'Yes',
        private string $falseLabel = 'No',
    ) {
    }

    public function modify(mixed $value, ?object $model = null): mixed
    {
        return $value ? $this->trueLabel : $this->falseLabel;
    }
}
