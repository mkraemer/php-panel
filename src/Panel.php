<?php

namespace Panel;

use Exception;
use React\Stream\Stream;
use React\EventLoop\LoopInterface;
use Panel\Module\PeriodiclyUpdatedModuleInterface;
use Panel\Module\EventedModuleInterface;

/**
 * Panel\Panel
 */
class Panel
{
    /** @var $loop React\EventLoop\LoopInterface */
    protected $loop;

    protected $renderer;

    public function __construct(LoopInterface $loop, Renderer $renderer, Stream $barStdin)
    {
        $this->loop = $loop;

        $this->renderer = $renderer;

        $lastUpdated = '';
        $renderer->on('update', function ($string) use ($barStdin, &$lastOutput) {
            if ($lastOutput != $string) {
                $lastOutput = $string;
                $barStdin->write($string . PHP_EOL);
            }
        });
    }

    public function add($module)
    {
        if ($module instanceof PeriodiclyUpdatedModuleInterface) {
            $this->loop->addPeriodicTimer($module->getInterval(), function () use ($module) {
                $this->renderer->__invoke($module->getKey(), $module());
            });

            $this->renderer->__invoke($module->getKey(), $module());
        } elseif ($module instanceof EventedModuleInterface) {
            $module->on('update', function ($data) use ($module) {
                $this->renderer->__invoke($module->getKey(), $data);
            });
        } else {
            throw new Exception('Unknown module type');
        }
    }
}
