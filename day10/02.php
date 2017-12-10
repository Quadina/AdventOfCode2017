<?php

$inputLength = 256;
$input = file_get_contents('input');
//$input = "3,4,1,5";
//$input = "AoC 2017";
$lines = [];
foreach (str_split($input) as $char) {
    $lines[] = ord($char);
}
$lines[] = 17;
$lines[] = 31;
$lines[] = 73;
$lines[] = 47;
$lines[] = 23;

$list = array_keys(array_fill(0, $inputLength, ''));

$currentPosition = 0;
$skipsize = 0;

for ($i = 0; $i < 64; $i++) {
    foreach ($lines as $input) {
        array_revert($list, $currentPosition, $input);
        $currentPosition += $input + $skipsize;
        $skipsize++;
    }
//    dumpList($list, $currentPosition);
}

for ($i = 0; $i < 16; $i++) {
    $s = array_slice($list, $i * 16, 16);
    $xor = $s[0];
    for ($j = 1; $j < 16; $j++) {
        $xor = $xor ^ $s[$j];
    }
    $str = dechex($xor);
    if (strlen($str) == 1) {
        echo '0';
    }
    echo $str;
}

function array_revert(&$list, $currentPosition, $input)
{
    $tmp = [];
    for ($i = 0; $i < $input; $i++) {
        $tmp[] = $list[($currentPosition + $i) % count($list)];
    }
    $tmp = array_reverse($tmp);
    foreach ($tmp as $i => $elem) {
        $list[($currentPosition + $i) % count($list)] = $elem;
    }
}

function dumpList($list, $current)
{
    foreach ($list as $key => $elem) {
        if ($key == $current) {
            echo '[';
        }
        echo $elem;
        if ($key == $current) {
            echo ']';
        }
        echo ' ';
    }
    echo "\n";
}