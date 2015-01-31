<?php

namespace Panel\Module;

use Evenement\EventEmitterTrait;
use React\EventLoop\LoopInterface;
use React\Stream\Stream;

/**
 * Panel\Module\BSPWM
 */
class BSPWM implements EventedModuleInterface
{
    use EventEmitterTrait;

    public function getKey()
    {
        return 'bspwm';
    }

    public function __construct(LoopInterface $loop)
    {
        $bspcProcess = proc_open(
            'bspc control --subscribe',
            [['pipe', 'r'], ['pipe', 'w']],
            $pipes
        );

        $bspcStdout = new Stream($pipes[1], $loop);

        $bspcStdout->on('data', [$this, 'onUpdate']);
    }

    public function onUpdate($data)
    {
        // WMeDP1:oTERMINALS:fCOMMUNICATION:OWORK:fWORK:fOTHER:Ltiled
        // WmeDP1:OTERMINALS:fCOMMUNICATION:fWORK:fWORK:fOTHER:LT:MHDMI1:OTERMINALS:fCOMMUNICATION:fWORK:fWORK:fOTHER:LT

        /*
         * when receiving multiple updates at the same time,
         * just process the last one:
         */
        $statusStrings = explode(PHP_EOL, $data);
        array_pop($statusStrings); // remove ending linebreak
        $statusString = array_pop($statusStrings);

        $parts = explode(':', $statusString);

        $monitor = array_shift($parts);
        $layout = array_pop($parts);

        $desktops = [];
        foreach ($parts as $desktop) {
            switch ($desktop[0]) {
                case 'O':
                case 'U':
                    $desktops[] = ['name' => substr($desktop, 1), 'occupied' => true, 'focused' => true];
                    break;

                case 'F':
                    $desktops[] = ['name' => substr($desktop, 1), 'occupied' => false, 'focused' => true];
                    break;

                case 'o':
                case 'u':
                    $desktops[] = ['name' => substr($desktop, 1), 'occupied' => true, 'focused' => false];
                    break;

                case 'f':
                    $desktops[] = ['name' => substr($desktop, 1), 'occupied' => false, 'focused' => false];
                    break;
            }
        }

        $this->emit('update', [['desktops' => $desktops]]);
    }
}
