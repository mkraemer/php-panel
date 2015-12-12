<?php

namespace Panel\Twig;

use Twig_Extension;

/**
 * Panel\Twig\ColorschemeExtension
 */
class ColorschemeExtension extends Twig_Extension
{
    protected $backgroundColor;
    protected $fontColor;
    protected $focusedDesktopColor;
    protected $occupiedDesktopColor;
    protected $unoccupiedDesktopColor;
    protected $batteryColor;
    protected $wifiColor;
    protected $soundUnmutedColor;
    protected $soundMutedColor;
    protected $timeColor;
    protected $splitterColor;

    public function __construct($backgroundColor, $fontColor, $focusedDesktopColor, $occupiedDesktopColor, $unoccupiedDesktopColor, $batteryColor, $wifiColor, $soundUnmutedColor, $soundMutedColor, $timeColor, $splitterColor)
    {
        $this->backgroundColor = $backgroundColor;

        $this->fontColor = $fontColor;

        $this->focusedDesktopColor = $focusedDesktopColor;

        $this->occupiedDesktopColor = $occupiedDesktopColor;

        $this->unoccupiedDesktopColor = $unoccupiedDesktopColor;

        $this->batteryColor = $batteryColor;

        $this->wifiColor = $wifiColor;

        $this->soundUnmutedColor = $soundUnmutedColor;

        $this->soundMutedColor = $soundMutedColor;

        $this->timeColor = $timeColor;

        $this->splitterColor = $splitterColor;
    }

    public function getGlobals()
    {
        return [
            'backgroundColor' => $this->backgroundColor,
            'fontColor' => $this->fontColor,
            'focusedDesktopColor' => $this->focusedDesktopColor,
            'occupiedDesktopColor' => $this->occupiedDesktopColor,
            'unoccupiedDesktopColor' => $this->unoccupiedDesktopColor,
            'batteryColor' => $this->batteryColor,
            'wifiColor' => $this->wifiColor,
            'soundUnmutedColor' => $this->soundUnmutedColor,
            'soundMutedColor' => $this->soundMutedColor,
            'timeColor' => $this->timeColor,
            'splitterColor' => $this->splitterColor
        ];
    }

    public function getName()
    {
        return 'colorscheme';
    }
}
