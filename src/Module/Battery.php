<?php

namespace BAR\Module;

/**
 * BAR\Module\Battery
 */
class Battery implements PeriodiclyUpdatedModuleInterface
{
    public function getKey()
    {
        return 'battery';    
    }

    public function getInterval()
    {
        return 60;
    }

    public function __invoke()
    {
        $percentage = file_get_contents('/sys/class/power_supply/BAT0/energy_now') / file_get_contents('/sys/class/power_supply/BAT0/energy_full') * 100;

        return $percentage;
    }
}
