<?php

namespace Panel\Module;

/**
 * Module\Sysload
 */
class Sysload implements PeriodiclyUpdatedModuleInterface
{
    protected $history;

    public function __construct()
    {
        $this->history = array_fill(0, 19, 0);
    }

    public function getKey()
    {
        return 'sysload';
    }

    public function getInterval()
    {
        return 60;
    }

    public function __invoke()
    {
        $sysload = sys_getloadavg();

        $this->history[] = $sysload[0];
        if (count($this->history) > 20) {
            array_shift($this->history);
        }

        return [
            'current' => $sysload[0],
            'history' => $this->history
        ];
    }
}
