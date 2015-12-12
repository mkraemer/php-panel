<?php

include __DIR__.'/vendor/autoload.php';

$loop = React\EventLoop\Factory::create();

$barProcess = proc_open(
    'lemonbar -g x18 -B "#FF20201d" -F "#FFFFFFFF" -f "Fantasque Sans Mono:pixelsize=14" -f "FontAwesome-10"',
    //'lemonbar -g x12 -B "#FF20201d" -F "#FFFFFFFF" -f "-*-terminus-*-*-*-*-*-*-*-*-*-*-iso10646-1" -f "FontAwesome-8"',
    [['pipe', 'r'], ['pipe', 'w']],
    $pipes
);

$barStdin = new React\Stream\Stream($pipes[0], $loop);

$twig = new Twig_Environment(new Twig_Loader_Filesystem(__DIR__.'/templates'));
$twig->addExtension(new Panel\Twig\BarTwigExtension());
$twig->addExtension(new Panel\Twig\PowerlineExtension());
$twig->addExtension(new Panel\Twig\HumanizeExtension());

array_shift($argv);
$colors = $argv;
if (count($colors) != 11) {
    throw new \InvalidArgumentException('Invalid amount of color arguments');
}
$twig->addExtension(new Panel\Twig\ColorschemeExtension(...$colors));

$template = $twig->loadTemplate('bar.twig');

$renderer = new Panel\Renderer($template);

$panel = new Panel\Panel($loop, $renderer, $barStdin);
$panel->add(new Panel\Module\Time());
$panel->add(new Panel\Module\Memory());
$panel->add(new Panel\Module\Filesystem());
$panel->add(new Panel\Module\Battery());
$panel->add(new Panel\Module\Wifi());
$panel->add(new Panel\Module\Sound($loop));
$panel->add(new Panel\Module\BSPWM($loop));

$loop->run();

fclose($pipes[0]);
fclose($pipes[1]);
proc_close($barProcess);
