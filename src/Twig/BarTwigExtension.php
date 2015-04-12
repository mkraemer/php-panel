<?php

namespace Panel\Twig;

use Twig_Extension;
use Twig_SimpleFunction;
use Twig_SimpleFilter;

/**
 * Panel\Twig\BarTwigExtension
 */
class BarTwigExtension extends Twig_Extension
{
    public function getName()
    {
        return 'bar';
    }

    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('color_bg', function ($color) {
                return sprintf('%%{B%s}', $color);
            }),

            new Twig_SimpleFunction('color_fg', function ($color) {
                return sprintf('%%{F%s}', $color);
            }),

            new Twig_SimpleFunction('unicode', function ($code) {
                return json_decode('"\u' . $code . '"');
            }),

            new Twig_SimpleFunction('powerline_desktops', function ($desktops) {
                $nextFocused = false;
                $elements = [];

                foreach (array_reverse($desktops, true) as $desktop) {
                    $desktop['next_focused'] = $nextFocused;
                    $elements[] = $desktop;
                    $nextFocused = $desktop['focused'];
                }

                return array_reverse($elements);
            })
        ];
    }

    public function getFilters()
    {
        return [
            new Twig_SimpleFilter('style', function ($content, $style) {
                $styled = ($style === 'underlined' ? '%{+u}' : '');

                $styled = $styled . $content;

                $styled = $styled . ($style === 'underlined' ? '%{-u}' : '');

                return $styled;
            }),

            new Twig_SimpleFilter('color_fg', function ($content, $color) {
                return sprintf('%%{F%s}%s%%{F-}', $color, $content);
            }),

            new Twig_SimpleFilter('color_bg', function ($content, $color) {
                return sprintf('%%{B%s}%s%%{B-}', $color, $content);
            }),

            new Twig_SimpleFilter('color_underline', function ($content, $color) {
                return sprintf('%%{U%s}%s%%{U-}', $color, $content);
            }),

        ];
    }
}
