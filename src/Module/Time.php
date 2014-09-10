<?php

namespace BAR\Module;

/**
 * BAR\Module\Time
 */
class Time implements PeriodiclyUpdatedModuleInterface
{
    public function getKey()
    {
        return 'time';    
    }

    public function getInterval()
    {
        return 10;
    }

    public function __invoke()
    {
       return date('H:i');
    }
}
