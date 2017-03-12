<?php

namespace Inferno\Foundation\Listeners;

use Inferno\Foundation\Events\User\PasswordChanged;

class UserEventListeners
{
	public function userPasswordChanged()
	{
		\Log::info('User password changed');
	}

	/**
	 * This is the function to subscribe the Events
	 */
	public function subscribe($events)
	{
		$class = 'Inferno\Foundation\Listeners\UserEventListeners';
		$events->listen(PasswordChanged::class, "{$class}@userPasswordChanged");
	}
}
