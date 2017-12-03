<?php

$input = 277678;
function spiralSplicer($input)
{
    $step_count = 1;
    $step_limit = 2;
    $adder = 1;
    $x = 0;
    $y = 0;
    for ($n = 2; $n != $input + 1; $n++, $step_count++) {
        if ($step_count <= .5 * $step_limit)
            $x += $adder;

        else if ($step_count <= $step_limit)
            $y += $adder;

        if ($step_count == $step_limit) {
            $adder *= -1;
            $step_limit += 2;
            $step_count = 0;
        }
    }
    return abs($x) + abs($y);
}

echo $input . ' -> ' . spiralSplicer($input) . "\n";
