<?php

namespace App\Decorators;

class JSDecorator extends UserWithSkill
{
    public function getDescription(): string
    {
        return parent::getDescription() . 'js, ';
    }
}

