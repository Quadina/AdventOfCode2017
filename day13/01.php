<?php

$input = "0: 3
1: 2
4: 4
6: 4";
$input = file_get_contents('input');

$walls = [];
$lines = explode("\n", $input);
$max = 0;
foreach ($lines as $line) {
    $params = explode(":", $line);
    $walls[(int)$params[0]] = [
        'max' => (int)$params[1],
        'step' => 0,
        'dir' => 0,
    ];
    $max = (int)$params[0] + 1;
}

$delayed = $walls;
function simulation($max)
{
    global $delayed;
    addPico($delayed);
    $walls = $delayed;
    $sum = null;
    for ($position = 0; $position < $max; $position++) {
        if (isset($walls[$position]) && $walls[$position]['step'] == 0) {
            $sum += $position * $walls[$position]['max'];
            break;
        }
        addPico($walls);
    }
    return $sum;
}

echo 'p1: ' . simulation($max) . "\n";

$delay = 1;
do {
    $delay++;
    $sum = simulation($max);
    if ($delay % 5000 == 0) {
        echo ".";
    }
} while ($sum !== null);
echo "\n";

echo 'p2: ' . $delay . "\n";

function addPico(&$walls)
{
    foreach ($walls as &$wall) {
        if ($wall['dir'] == 0) {
            if ($wall['step'] < $wall['max'] - 1) {
                $wall['step']++;
                if ($wall['step'] == $wall['max'] - 1) {
                    $wall['dir'] = 1;
                }
            }
        } else {
            if ($wall['step'] > 0) {
                $wall['step']--;
                if ($wall['step'] == 0) {
                    $wall['dir'] = 0;
                }
            }
        }
    }
}

function dumpWall($walls, $position = -1)
{
    foreach ($walls as $key => $wall) {
        echo $key . ' ';
        echo $wall['dir'] == 0 ? '->' : '<-';
        echo $position == $key ? '#' : ' ';
        for ($i = 0; $i < $wall['max']; $i++) {
            echo $i == $wall['step'] ? "S" : ".";
        }
        echo "\n";
    }
}