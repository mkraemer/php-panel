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
        $data = shell_exec('iw wlp3s0 link');

        preg_match('/SSID:\s(?P<SSID>\w+)$/ms', $data, $matches);
        $essid = $matches['SSID'];

        return ['essid' => $essid];
    }
}
