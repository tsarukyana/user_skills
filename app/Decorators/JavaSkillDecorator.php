<?php

namespace App\Decorators;

class JavaSkillDecorator extends UserDecorator
{
    public function getDescription(): string
    {
        return $this->user->description . ' java';
    }
}
