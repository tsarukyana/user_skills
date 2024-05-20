<?php

namespace App\Decorators;

class GoDecorator extends UserWithSkill
{
    public function getDescription(): string
    {
        return parent::getDescription() . 'golang, ';
    }
}

