<?php

namespace Inferno\Foundation\Listeners;

use Illuminate\Support\Facades\Auth;
use Inferno\Foundation\Events\User\Deleted;
use Inferno\Foundation\Events\User\Login;
use Inferno\Foundation\Events\User\Logout;
use Inferno\Foundation\Events\User\PasswordChanged;
use Inferno\Foundation\Events\User\UserEdited;
use Inferno\Foundation\Services\Logger;

class UserEventListeners
{
	protected $logger;
	/**
	 * This is the construct function.
	 */
	public function __construct(Logger $logger)
	{
		$this->logger = $logger;
	}

	/**
	 * Handling the event for User login
	 */
	public function userLoggedIn()
	{
		$userName = Auth::user()->name;
		$this->logger->log("User {$userName} logged in");
	}

	/**
	 * Handling the event for User logout
	 */
	public function userLogout()
	{
		$userName = Auth::user()->name;
		$this->logger->log("User {$userName} logged out");
	}

	/**
	 * Handling the user password changed event
	 */
	public function userPasswordChanged()
	{
		$userName = Auth::user()->name;
		$this->logger->log("User {$userName} password changed");
	}

	public function userDeleted(Deleted $event)
	{
	    $name = $event->getName();
	    $this->logger->log("A user {$name} was deleted.");
	}

	/**
	 * Handling the user edited event.
	 */
	public function userEdited(UserEdited $event)
	{
		$name = $event->getName();
	    $this->logger->log("A user {$name} was edited.");
	}

	/**
	 * This is the function to subscribe the Events
	 */
	public function subscribe($events)
	{
		$class = 'Inferno\Foundation\Listeners\UserEventListeners';
		$events->listen(PasswordChanged::class, "{$class}@userPasswordChanged");
		$events->listen(Login::class, "{$class}@userLoggedIn");
		$events->listen(Logout::class, "{$class}@userLogout");
		$events->listen(Deleted::class, "{$class}@userDeleted");
		$events->listen(UserEdited::class, "{$class}@userEdited");
	}
}
