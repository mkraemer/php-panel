<?php

include __DIR__.'/vendor/autoload.php';

$loop = React\EventLoop\Factory::create();

$barProcess = proc_open(
    'bar-aint-recursive -g x12 -B "#88000000" -F "#FFFFFFFF" -f "-*-fixed-*-*-*-*-9-*-*-*-*-*-*-*,-*-stlarch-*-*-*-*-10-*-*-*-*-*-*-*"',
    [['pipe', 'r'], ['pipe', 'w']],
    $pipes
);

$barStdin = new React\Stream\Stream($pipes[0], $loop);

$twig = new Twig_Environment(new Twig_Loader_Filesystem(__DIR__.'/templates'));
$twig->addExtension(new BAR\Twig\BarTwigExtension());

$template = $twig->loadTemplate('bar.twig');

$renderer = new BAR\Renderer($template);

$panel = new BAR\Panel($loop, $renderer, $barStdin);
$panel->add(new BAR\Module\Time());
$panel->add(new BAR\Module\Battery());
$panel->add(new BAR\Module\Memory());
$panel->add(new BAR\Module\Sound());
$panel->add(new BAR\Module\BSPWM($loop));

$loop->run();

fclose($pipes[0]);
fclose($pipes[1]);
proc_close($barProcess);
