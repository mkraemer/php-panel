<?php

namespace BAR;

use Evenement\EventEmitterTrait;
use Twig_Environment;

/**
 * BAR\Renderer
 */
class Renderer
{
    use EventEmitterTrait;

    protected $data = [];

    protected $template;

    public function __construct($template)
    {
        $this->template = $template;
    }

    public function __invoke($key, $value)
    {
        $this->data[$key] = $value;

        $output = $this->template->render($this->data);

        $this->emit('update', [$output]);
    }
}
