<?php

namespace BAR\Module;

use Evenement\EventEmitterTrait;
use React\EventLoop\LoopInterface;
use React\Stream\Stream;

/**
 * BAR\Module\BSPWM
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
            $lala
        );

        $bspcStdout = new Stream($lala[1], $loop);

        $bspcStdout->on('data', [$this, 'onUpdate']);
    }

    public function onUpdate($data)
    {
        // WMeDP1:oTERMINALS:fCOMMUNICATION:OWORK:fWORK:fOTHER:Ltiled
        
        $parts = explode(':', $data);

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
