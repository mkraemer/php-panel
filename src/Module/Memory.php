<?php

namespace Panel\Module;

/**
 * Panel\Module\Memory
 */
class Memory implements PeriodiclyUpdatedModuleInterface
{
    public function getKey()
    {
        return 'memory';
    }

    public function getInterval()
    {
        return 60;
    }

    public function __invoke()
    {
        $meminfo = file_get_contents('/proc/meminfo');

        $items = [];
        $rows = explode("\n", $meminfo);
        array_pop($rows);

        foreach ($rows as $row) {
            $keyValue = explode(':', $row);
            $items[$keyValue[0]] = trim($keyValue[1]);
        }

        $total = str_replace(' kB', '', $items['MemTotal']);
        $available = str_replace(' kB', '', $items['MemAvailable']);

        $percentage = (1 - ($available / $total)) * 100;

        return [
            'percentage' => $percentage,
            'available' => $available * 1024
        ];
    }
}
