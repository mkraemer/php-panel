<?php

namespace Panel\Module;

/**
 * Panel\Module\PeriodiclyUpdatedModuleInterface
 */
interface PeriodiclyUpdatedModuleInterface
{
    public function getKey();

    public function getInterval();

    public function __invoke();
}
