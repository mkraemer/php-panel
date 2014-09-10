<?php

namespace Panel\Module;

/**
 * Panel\Module\EventedModuleInterface
 */
interface EventedModuleInterface
{
    public function getKey();

    public function on($event, callable $listener);
}
