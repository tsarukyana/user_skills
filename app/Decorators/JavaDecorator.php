<?php

namespace App\Decorators;

class JavaDecorator extends UserWithSkill
{
    public function getDescription(): string
    {
        return parent::getDescription() . 'java, ';
    }
}

