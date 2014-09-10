<?php

namespace BAR\Module;

/**
 * BAR\Module\Sound
 */
class Sound implements PeriodiclyUpdatedModuleInterface
{
    public function getKey()
    {
        return 'sound';    
    }

    public function getInterval()
    {
        return 1;
    }

    public function __invoke()
    {
        $sinks = shell_exec('pacmd list-sinks');

        preg_match('/index:\s1.+^\s+muted:\s(?P<muted>\w+)$/ms', $sinks, $matches);
        $muted = $matches['muted'] == 'yes';

        preg_match('/index:\s1.+^\s+volume:\s\w+-\w+:\s*\d+\s*\/\s*(?P<volume>\d+)/ms', $sinks, $matches);
        $volume = $matches['volume'];

        return ['isMuted' => $muted, 'volume' => $volume];
    }
}
