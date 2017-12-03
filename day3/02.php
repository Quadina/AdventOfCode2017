<?php

$limit = 100;
$input = 277678;
$table = [0 => [0 => 1]];
function spiralSplicer(&$table, $limit, $input)
{
    $step_count = 1;
    $step_limit = 2;
    $adder = 1;
    $x = 0;
    $y = 0;
    for ($n = 2; $n != $limit + 1; $n++, $step_count++) {
        if ($step_count <= .5 * $step_limit)
            $x += $adder;

        else if ($step_count <= $step_limit)
            $y += $adder;

        if ($step_count == $step_limit) {
            $adder *= -1;
            $step_limit += 2;
            $step_count = 0;
        }
        $table[$x][$y] = sumNaighbor($table, $x, $y);
        if ($table[$x][$y] > $input) {
            return [$n, $table[$x][$y]];
        }
    }
    return null;
}

function sumNaighbor($table, $x, $y)
{
    $sum = 0;
    foreach ([[-1, -1], [-1, 0], [-1, 1], [1, -1], [1, 0], [1, 1], [0, -1], [0, 1]] as $coords) {
        if (isset($table[$x + $coords[0]][$y + $coords[1]])) {
            $sum += $table[$x + $coords[0]][$y + $coords[1]];
        }
    }
    return $sum;
}

function dumpTable($table)
{
    ksort($table);
    foreach ($table as $line) {
        ksort($line);
        echo implode("\t", $line) . "\n";
    }
}

$result = spiralSplicer($table, $limit, $input);
dumpTable($table);

echo $result[0] . ' -> ' . $result[1] . "\n";