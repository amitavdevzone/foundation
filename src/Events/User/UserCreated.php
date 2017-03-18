<?php

namespace Inferno\Foundation\Events\User;

use App\User;

class UserCreated
{
	protected $user;
	/**
	 * This is the __construct function
	 */
	public function __construct(User $user)
	{
		$this->user = $user;
	}

	/**
	 * Getter for the username.
	 */
	public function getName()
	{
		return $this->user->name;
	}
}
