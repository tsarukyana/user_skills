<?php

namespace App\Decorators;

class PhpSkillDecorator extends UserDecorator
{
    public function getDescription(): string
    {
        return $this->user->description . ' php';
    }
}
