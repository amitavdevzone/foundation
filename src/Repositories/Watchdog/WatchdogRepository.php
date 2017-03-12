<?php

namespace Inferno\Foundation\Repositories\Watchdog;

use Inferno\Foundation\Repositories\AbstractInterface;

interface WatchdogRepository extends AbstractInterface
{
    public function getUserActivityList($userId, array $options);

    public function getUserActivityGraph($userId);
}
