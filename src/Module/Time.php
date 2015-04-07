<?php

namespace Panel\Module;

/**
 * Panel\Module\Time
 */
class Time implements PeriodiclyUpdatedModuleInterface
{
    public function getKey()
    {
        return 'time';
    }

    public function getInterval()
    {
        return 60;
    }

    public function __invoke()
    {
       return date('H:i');
    }
}
