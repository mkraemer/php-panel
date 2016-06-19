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
            'bspc subscribe report',
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
        // WmeDP1    FEXT    LT    MDP1    oWEB    OCOM    oSYS    oDEV    fDEV    fSQL    LT    TF    GS

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
                    $desktops[] = ['name' => substr($desktop, 1), 'occupied' => true, 'focused' => true, 'urgent' => false];
                    break;

                case 'U':
                    $desktops[] = ['name' => substr($desktop, 1), 'occupied' => true, 'focused' => true, 'urgent' => true];
                    break;

                case 'F':
                    $desktops[] = ['name' => substr($desktop, 1), 'occupied' => false, 'focused' => true, 'urtent' => false];
                    break;

                case 'u':
                    $desktops[] = ['name' => substr($desktop, 1), 'occupied' => true, 'focused' => false, 'urgent' => true];
                    break;

                case 'o':
                    $desktops[] = ['name' => substr($desktop, 1), 'occupied' => true, 'focused' => false, 'urgent' => false];
                    break;

                case 'f':
                    $desktops[] = ['name' => substr($desktop, 1), 'occupied' => false, 'focused' => false, 'urgent' => false];
                    break;
            }
        }

        $this->emit('update', [['desktops' => $desktops]]);
    }
}
