<?php

namespace Inferno\Foundation\Listeners;

use Inferno\Foundation\Events\Permissions\PermissionCreated;
use Inferno\Foundation\Events\Permissions\PermissionDeleted;
use Inferno\Foundation\Events\Roles\RoleCreated;
use Inferno\Foundation\Events\Roles\RoleDeleted;
use Inferno\Foundation\Services\Logger;

class RolePermissionEventListner
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
	 * Handling the role created event.
	 */
	public function roleCreated(RoleCreated $event)
	{
		$name = $event->getName();
        $this->logger->log("A new role {$name} was created.");
	}

	/**
	 * Handling the permission created event.
	 */
	public function permissionCreated(PermissionCreated $event)
	{
		$name = $event->getName();
        $this->logger->log("A new permission {$name} was created.");
	}

	/**
	 * Handling the role deleted event.
	 */
	public function roleDeleted(RoleDeleted $event)
	{
		$name = $event->getName();
        $this->logger->log("A role {$name} was deleted.");
	}

	/**
	 * Handling the permission deleted event.
	 */
	public function permissionDeleted(PermissionDeleted $event)
	{
		$name = $event->getName();
        $this->logger->log("A permission {$name} was deleted.");
	}

	/**
	 * This is the function to subscribe the Events
	 */
	public function subscribe($events)
	{
		$class = 'Inferno\Foundation\Listeners\RolePermissionEventListner';
		$events->listen(RoleCreated::class, "{$class}@roleCreated");
		$events->listen(RoleDeleted::class, "{$class}@roleDeleted");
		$events->listen(PermissionCreated::class, "{$class}@permissionCreated");
		$events->listen(PermissionDeleted::class, "{$class}@permissionDeleted");
	}
}
