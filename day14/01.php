<?php
include "tools.php";

$input = "flqrgnkx";
$input = "xlqgujun";
//echo toBitRepresentation('a0c2017');

$grid = [];
$sum = 0;
for ($i = 0; $i < 128; $i++) {
    $string = $input . '-' . $i;
    $hash = knot_hash($string);
    $sum += toBitRepresentation($hash);
}
echo 'p1: ' . $sum . "\n";

function toBitRepresentation($string)
{
    $map = [
        0 => 0,
        1 => 1,
        2 => 1,
        3 => 2,
        4 => 1,
        5 => 2,
        6 => 2,
        7 => 3,
        8 => 1,
        9 => 2,
        'a' => 2,
        'b' => 3,
        'c' => 2,
        'd' => 3,
        'e' => 3,
        'f' => 4,
    ];
    $out = '';
    for ($i = 0; $i < strlen($string); $i++) {
        $out += $map[$string[$i]];
    }
    return $out;
}
