<?php

namespace Panel\Twig;

use Twig_Extension;
use Twig_SimpleFunction;

/**
 * Twig\SparklineExtension
 */
class SparklineExtension extends Twig_Extension
{
    public function getName()
    {
        return 'sparkline';
    }

    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('sparkline', [$this, '__invoke']),
        ];
    }

    private function getBraille($first, $second) {
        switch ($first.$second) {
        case '00':
            return '⠀';
        case '01':
            return '⢀';
        case '02':
            return '⢠';
        case '03':
            return '⢰';
        case '04':
            return '⢸';

        case '10':
            return '⡀';
        case '11':
            return '⣀';
        case '12':
            return '⣠';
        case '13':
            return '⣰';
        case '14':
            return '⣸';

        case '20':
            return '⡄';
        case '21':
            return '⣄';
        case '22':
            return '⣤';
        case '23':
            return '⣴';
        case '24':
            return '⣼';

        case '30':
            return '⡆';
        case '31':
            return '⣆';
        case '32':
            return '⣦';
        case '33':
            return '⣶';
        case '34':
            return '⣾';

        case '40':
            return '⡇';
        case '41':
            return '⣇';
        case '42':
            return '⣧';
        case '43':
            return '⣷';
        case '44':
            return '⣿';
        }
    }

    private function characterGenerator(array $values) {
        $min = min($values);
        $max = max($values);
        $range = abs($max - $min) ?: 1;

        if (count($values) % 2 !== 0) {
            $values[] = $values[count($values) - 1];
        }

        $lastMapped = null;
        foreach ($values as $value) {
            $mapped = (int) round((($value - $min) / $range) * 4);

            if ($lastMapped === null) {
                $lastMapped = $mapped;
                continue;
            }

            $braille = $this->getBraille($lastMapped, $mapped);
            $lastMapped = null;
            yield $braille;
        }
    }

    public function __invoke($data)
    {
        if (!$data) {
            return '';
        }
        $characterGenerator = $this->characterGenerator($data);

        $characters = iterator_to_array($characterGenerator);

        return implode($characters);
    }
}
