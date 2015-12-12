<?php

namespace Panel\Module;

/**
 * Panel\Module\Filesystem
 */
class Filesystem implements PeriodiclyUpdatedModuleInterface
{
    public function getKey()
    {
        return 'filesystem';
    }

    public function getInterval()
    {
        return 60;
    }

    public function __invoke()
    {
        return disk_free_space('/');
    }
}

