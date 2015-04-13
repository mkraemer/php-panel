<?php

namespace Panel\Twig;

use Twig_Extension;
use Twig_SimpleFunction;
use Twig_SimpleFilter;

/**
 * Panel\Twig\PowerlineExtension
 */
class PowerlineExtension extends Twig_Extension
{
    public function getName()
    {
        return 'powerline';
    }

    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('inject_splitters_gravity_left', [$this, 'injectSplittersGravityLeft']),
            new Twig_SimpleFunction('inject_splitters_gravity_right', [$this, 'injectSplittersGravityRight']),
            new Twig_SimpleFunction('convert_desktops', [$this, 'convertDesktops']),
        ];
    }

    public function injectSplittersGravityLeft($elements, $backgroundColor, $splitterColor)
    {
        $elementsAndSplitters = [];

        foreach ($elements as $key => $element) {
            $element['content'] = ' ' . $element['content'] . ' ';
            $elementsAndSplitters[] = $element;

            // if we're on the last element, make an ending element
            if ($key === count($elements) - 1) {
                $splitter = ['content' => '', 'fg_color' => $element['bg_color'], 'bg_color' => $backgroundColor];
            } else {
                $nextElement = $elements[$key + 1];

                if ($element['bg_color'] !== $nextElement['bg_color'] ) {
                    $splitter = ['content' => '', 'bg_color' => $nextElement['bg_color'], 'fg_color' => $element['bg_color']];
                } else {
                    $splitter = ['content' => '', 'bg_color' => $element['bg_color'], 'fg_color' => $splitterColor];
                }
            }

            $elementsAndSplitters[] = $splitter;
        }

        return $elementsAndSplitters;
    }

    public function injectSplittersGravityRight($elements, $backgroundColor, $splitterColor)
    {
        $elementsAndSplitters = [
            ['content' => '', 'fg_color' => $elements[0]['bg_color'], 'bg_color' => $backgroundColor]
        ];

        foreach ($elements as $key => $element) {
            $element['content'] = ' ' . $element['content'] . ' ';
            $elementsAndSplitters[] = $element;

            if ($key !== count($elements) - 1) {
                $nextElement = $elements[$key + 1];

                if ($element['bg_color'] !== $nextElement['bg_color'] ) {
                    $splitter = ['content' => '', 'bg_color' => $element['bg_color'], 'fg_color' => $nextElement['bg_color']];
                } else {
                    $splitter = ['content' => '', 'bg_color' => $element['bg_color'], 'fg_color' => $splitterColor];
                }

            $elementsAndSplitters[] = $splitter;

            }
        }

        return $elementsAndSplitters;
    }

    public function convertDesktops($desktops, $activeColor, $occupiedColor, $unoccupiedColor, $foregroundColor)
    {
        if (empty($desktops)) {
            return [];
        }

        foreach ($desktops as &$desktop) {
            $desktop['fg_color'] = $foregroundColor;
            $desktop['content'] = $desktop['name'];

            switch (true) {
                case $desktop['focused']:
                    $desktop['bg_color'] = $activeColor;
                    break;
                case $desktop['occupied']:
                    $desktop['bg_color'] = $occupiedColor;
                    break;
                default:
                    $desktop['bg_color'] = $unoccupiedColor;
                    break;
            }
        }

        return $desktops;
    }
}
