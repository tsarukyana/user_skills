<?php

namespace App\Decorators;

use App\Models\User;

class UserWithSkill implements SkillInterface
{
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function getDescription(): string
    {
        return $this->user->description ?? '';
    }
}
