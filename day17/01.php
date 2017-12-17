<?php

$input = 367;

$pos = 0;
$map = [0];

$max = 2017;
for ($i = 0; $i < $max; $i++) {
//    echo implode(' ', $map) . "\n";

    $pos = ($pos + $input) % count($map);
    array_splice($map, $pos + 1, 0, $i + 1);
    $pos++;
    if ($i % 10000 == 0){
        echo round($i / $max * 100, 1) . "\t";

    }
}

$lastPos = array_search(2017, $map);

echo $map[$lastPos] . "\n";
echo $map[$lastPos + 1] . "\n";