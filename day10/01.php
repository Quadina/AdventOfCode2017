<?php
error_reporting(E_ALL);

$inputLength = 5;
$input = "3,4,1,5";

$inputLength = 256;
$input = file_get_contents('input');

$list = array_keys(array_fill(0, $inputLength, ''));
$lines = explode(",", $input);

$currentPosition = 0;
$skipsize = 0;

foreach ($lines as $input) {
    array_revert($list, $currentPosition, $input);
    dumpList($list, $currentPosition);
    $currentPosition += $input + $skipsize;
    $skipsize++;
}

echo 'p1:' . ($list[0] * $list[1]);

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