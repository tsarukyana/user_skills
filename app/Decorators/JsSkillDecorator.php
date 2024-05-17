<?php

namespace App\Decorators;

class JsSkillDecorator extends UserDecorator
{
    public function getDescription(): string
    {
        return $this->user->description . ' js';
    }
}
