<?php

namespace Panel\Twig;

use Twig_Extension;
use Twig_SimpleFunction;
use Twig_SimpleFilter;
use Coduo\PHPHumanizer\Number;

/**
 * Panel\Twig\HumanizeExtension
 */
class HumanizeExtension extends Twig_Extension
{
    public function getName()
    {
        return 'humanize';
    }

    public function getFilters()
    {
        return [
            new Twig_SimpleFilter('binarySuffix', function ($number) {
                return Number::binarySuffix($number);
            }),

        ];
    }
}

