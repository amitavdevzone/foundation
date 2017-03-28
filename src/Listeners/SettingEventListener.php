<?php

namespace Inferno\Foundation\Listeners;

use Inferno\Foundation\Events\Settings\SettingsCreated;
use Inferno\Foundation\Services\Logger;

class SettingEventListener
{
    protected $logger;

    /**
     * SettingEventListener constructor.
     * @param Logger $logger
     */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param SettingsCreated $event
     */
    public function settingCreated(SettingsCreated $event)
    {
        $desc = $event->getString();
        $this->logger->log($desc);
    }

    /**
     * This is the function to subscribe the Events
     */
    public function subscribe($events)
    {
        $class = 'Inferno\Foundation\Listeners\SettingEventListener';
        $events->listen(SettingsCreated::class, "{$class}@settingCreated");
    }
}