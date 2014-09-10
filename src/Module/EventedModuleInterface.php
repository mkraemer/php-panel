<?php

namespace BAR\Module;

/**
 * BAR\Module\EventedModuleInterface
 */
interface EventedModuleInterface
{
    public function getKey();

    public function on($event, callable $listener);
}
