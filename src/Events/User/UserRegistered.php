<?php

namespace Inferno\Foundation\Events\User;

use App\User;

class UserRegistered
{
    private $user;

    function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getName()
    {
        return $this->user->name;
    }
}
