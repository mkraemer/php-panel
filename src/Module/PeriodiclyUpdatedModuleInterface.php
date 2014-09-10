<?php

namespace BAR\Module;

/**
 * BAR\Module\PeriodiclyUpdatedModuleInterface
 */
interface PeriodiclyUpdatedModuleInterface
{
    public function getKey();

    public function getInterval();

    public function __invoke();
}
