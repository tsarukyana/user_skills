<?php

namespace App\Decorators;

class PHPDecorator extends UserWithSkill
{
    public function getDescription(): string
    {
        return parent::getDescription() . 'php, ';
    }
}

