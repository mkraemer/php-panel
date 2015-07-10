<?php

namespace Panel\Twig;

use Twig_Extension;

/**
 * Panel\Twig\ColorschemeExtension
 */
class ColorschemeExtension extends Twig_Extension
{
    public function getGlobals()
    {
        return [
            'color0'  => '#FF20201d',
            'color1'  => '#FFd73737',
            'color2'  => '#FF60ac39',
            'color3'  => '#FFcfb017',
            'color4'  => '#FF6684e1',
            'color5'  => '#FFb854d4',
            'color6'  => '#FF1fad83',
            'color7'  => '#FFa6a28c',
            'color8'  => '#FF7d7a68',
            'color9'  => '#FFd73737',
            'color10' => '#FF60ac39',
            'color11' => '#FFcfb017',
            'color12' => '#FF6684e1',
            'color13' => '#FFb854d4',
            'color14' => '#FF1fad83',
            'color15' => '#FFfefbec',
            'color16' => '#FFb65611',
            'color17' => '#FFd43552',
            'color18' => '#FF292824',
            'color19' => '#FF6e6b5e',
            'color20' => '#FF999580',
            'color21' => '#FFe8e4cf'
        ];
    }

    public function getName()
    {
        return 'colorscheme';
    }
}
