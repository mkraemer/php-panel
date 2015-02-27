<?php

namespace Panel\Module;

use Evenement\EventEmitterTrait;
use React\EventLoop\LoopInterface;
use React\Stream\Stream;

/**
 * Panel\Module\Sound
 */
class Sound implements EventedModuleInterface
{
    use EventEmitterTrait;

    public function getKey()
    {
        return 'sound';
    }

    public function __construct(LoopInterface $loop)
    {
        $bspcProcess = proc_open(
            'pactl subscribe',
            [['pipe', 'r'], ['pipe', 'w']],
            $pipes
        );

        $bspcStdout = new Stream($pipes[1], $loop);

        $bspcStdout->on('data', [$this, 'onUpdate']);

        $loop->addTimer(0, function () {$this->queryData();});
    }

    public function onUpdate($data)
    {
        if (strpos($data, 'Event \'change\' on sink') !== false) {
            $this->queryData();
        }
    }

    private function queryData()
    {
        $sinks = shell_exec('pacmd list-sinks');

        preg_match('/index:\s1.+^\s+muted:\s(?P<muted>\w+)$/ms', $sinks, $matches);
        $muted = $matches['muted'] == 'yes';

        preg_match('/index:\s1.+^\s+volume:\s\w+-\w+:\s*\d+\s*\/\s*(?P<volume>\d+)/ms', $sinks, $matches);
        $volume = $matches['volume'];

        $this->emit('update', [['isMuted' => $muted, 'volume' => $volume]]);
    }
}
