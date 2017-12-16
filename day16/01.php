<?php

$input = "s1,x3/4,p3/b";
$input = file_get_contents('input');

$moves = explode(",", $input);

$programs = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p'];

$hash = [];
$max = 1000000000;
for ($i = 0; $i < 1000000000; $i++) {
    $key = dumpPrograms($programs);
    if (isset($hash[$key])) {
        if ($i % 1000000 == 0) {
            echo round($i / $max * 100, 1) . "\t";
            echo dumpPrograms($programs) . "\n";
        }
        $programs = $hash[$key];
        continue;
    }
    foreach ($moves as $move) {
        if ($move[0] == 's') {
            $spin = (int)substr($move, 1);
            for ($z = 0; $z < $spin; $z++) {
                array_unshift($programs, array_pop($programs));
            }
        }
        if ($move[0] == 'x') {
            list($posA, $posB) = explode("/", substr($move, 1));
            changePosition($programs, $posA, $posB);
        }
        if ($move[0] == 'p') {
            list($letA, $letB) = explode("/", substr($move, 1));
            $posA = array_search($letA, $programs);
            $posB = array_search($letB, $programs);
            changePosition($programs, $posA, $posB);
        }
    }
    $hash[$key] = $programs;
    if ($i % 100 == 0) echo round($i / $max * 100, 1) . "\t";
}
echo dumpPrograms($programs) . "\n";

function changePosition(&$programs, $posA, $posB)
{
    $tmp = $programs[$posA];
    $programs[$posA] = $programs[$posB];
    $programs[$posB] = $tmp;
}

function dumpPrograms($programs)
{
    return implode("", $programs);
}