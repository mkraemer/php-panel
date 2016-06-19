<?php

namespace Panel\Module;

/**
 * Panel\Module\Wifi
 */
class Wifi implements PeriodiclyUpdatedModuleInterface
{
    public function getKey()
    {
        return 'wifi';
    }

    public function getInterval()
    {
        return 60;
    }

    public function __invoke()
    {
        $essid = shell_exec('iwgetid -r');

        return ['essid' => $essid];
    }
}
