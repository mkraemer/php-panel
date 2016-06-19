<?php

namespace Panel\Twig;

use Twig_Extension;

/**
 * Panel\Twig\ColorschemeExtension
 */
class ColorschemeExtension extends Twig_Extension
{
    protected $backgroundColor;
    protected $foregroundColor;
    protected $urgentColor;
    protected $unoccupiedColor;

    public function __construct()
    {
        $this->backgroundColor = '#00000000';

        $this->foregroundColor = '#FFf7f7f7';

        $this->urgentColor = '#FFFF5858';

        $this->unoccupiedColor = '#FF666666';
    }

    public function getGlobals()
    {
        return [
            'backgroundColor' => $this->backgroundColor,
            'foregroundColor' => $this->foregroundColor,
            'urgentColor' => $this->urgentColor,
            'unoccupiedColor' => $this->unoccupiedColor,
        ];
    }

    public function getName()
    {
        return 'colorscheme';
    }
}
