<?php
$input = "10	3	15	10	5	15	5	15	9	2	5	8	5	2	3	6";

// test case
//$input = "0	2	7	0";

$bank = explode("\t", $input);
$bank = array_map(function ($n) {
    return (int)$n;
}, $bank);
$length = count($bank);

$cursor = 0;
$hashs = [];

$counter = 0;
do {
    if (isset($hashs[implode('_', $bank)])) {
        break;
    }
    $hashs[implode('_', $bank)] = $counter;
    $cursor = array_search(max($bank), $bank);
    $value = $bank[$cursor];
    $bank[$cursor] = 0;

    ksort($bank);
    for ($i = $cursor + 1; $i <= $cursor + $value; $i++) {
        $bank[$i % $length]++;
    }
    $counter++;
//    for debug
//    echo implode(' ', $bank) . "\n";
} while (true);
echo 'counter: ' . $counter . "\n";
echo 'distance: ' . ($counter - $hashs[implode('_', $bank)]) . "\n";
