<?php

$input = 367;

$pos = 0;
$map = [0];

$valueAfterZero = 0;
$max = 50000000;
//$max = 2017;
for ($i = 0; $i < $max; $i++) {
    $pos = ($pos + $input) % ($i + 1);
    if ($pos == 0) {
        $valueAfterZero = $i + 1;
    }
    $pos++;
    if ($i % 1000000 == 0) {
        echo round($i / $max * 100, 1) . "\t";
        echo $valueAfterZero . "\n";
    }
}

echo $valueAfterZero . "\n";