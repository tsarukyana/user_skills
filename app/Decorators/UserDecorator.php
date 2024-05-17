<?php

namespace App\Decorators;

use App\Models\User;

abstract class UserDecorator
{
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    abstract public function getDescription(): string;
}
