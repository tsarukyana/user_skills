<?php

namespace App\Decorators;

class GolangSkillDecorator extends UserDecorator
{
    public function getDescription(): string
    {
        return $this->user->description . ' golang';
    }
}
