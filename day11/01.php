<?php
//$input = "ne,ne,sw,sw";
//$input = "ne,ne,s,s";
//$input = "se,sw,se,sw,sw";
$input = file_get_contents('input');

$lines = explode(",", $input);

function distance($lines)
{
    $step = [
        'n' => 0,
        's' => 0,
        'nw' => 0,
        'ne' => 0,
        'se' => 0,
        'sw' => 0,
    ];
    foreach ($lines as $line) {
        $step[$line]++;
    }

    $opositDir = [
        'nw' => 'se',
        'n' => 's',
        'ne' => 'sw',
    ];
    foreach ($opositDir as $l => $r) {
        $min = min($step[$l], $step[$r]);
        $step[$l] -= $min;
        $step[$r] -= $min;
    }

    $traingle = [
        'se' => ['ne', 's'],
        's' => ['se', 'sw'],
        'sw' => ['s', 'nw'],
        'nw' => ['sw', 'n'],
        'n' => ['nw', 'ne'],
        'ne' => ['n', 'se'],
    ];
    foreach ($traingle as $dir => $prof) {
        $min = min($step[$prof[0]], $step[$prof[1]]);
        $step[$prof[0]] -= $min;
        $step[$prof[1]] -= $min;
        $step[$dir] += $min;
    }
    return array_sum($step);
}

$tmp = [];
$max = 0;
foreach ($lines as $line) {
    $tmp[] = $line;
    $localMax = distance($tmp);
    if ($max < $localMax) {
        $max = $localMax;
    }
}

echo 'p1: ' . $localMax . "\n";
echo 'p2: ' . $max . "\n";