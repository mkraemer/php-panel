<?php

namespace Panel;

use Evenement\EventEmitterTrait;
use Twig_Environment;

/**
 * Panel\Renderer
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

        $output = str_replace(array("\r", "\n"), "", $output);

        $this->emit('update', [$output]);
    }
}
