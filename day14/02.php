<?php
include "tools.php";

$input = "flqrgnkx";
$input = "xlqgujun";
//echo toBitRepresentation('a0c2017');

$grid = [];
$map = [];
for ($i = 0; $i < 128; $i++) {
    $string = $input . '-' . $i;
    $hash = knot_hash($string);
    $map[] = toBitRepresentation($hash);
}

$group = 0;
foreach ($map as $x => &$line) {
    foreach ($line as $y => &$val) {
        if ($val == '_') {
            $group++;
            markOnMap($map, $x, $y, $group);
        }
    }
}
dumpMap($map);
echo 'p2: ' . $group . "\n";

function markOnMap(&$map, $x, $y, $group)
{
    $map[$x][$y] = $group;
    if (isset($map[$x - 1][$y]) && $map[$x - 1][$y] == '_') {
        markOnMap($map, $x - 1, $y, $group);
    }
    if (isset($map[$x + 1][$y]) && $map[$x + 1][$y] == '_') {
        markOnMap($map, $x + 1, $y, $group);
    }
    if (isset($map[$x][$y - 1]) && $map[$x][$y - 1] == '_') {
        markOnMap($map, $x, $y - 1, $group);
    }
    if (isset($map[$x][$y + 1]) && $map[$x][$y + 1] == '_') {
        markOnMap($map, $x, $y + 1, $group);
    }
}

function dumpMap($map)
{
    foreach ($map as $x => $line) {
        foreach ($line as $y => $val) {
            if ($val == '.') {
                echo ' ';
            } else {
                echo chr(($val % 128) + 64);
            }
        }
        echo "\n";
    }
}


/**
 * @param $string
 * @return array
 */
function toBitRepresentation($string)
{
    $map = [
        0 => '0000',
        1 => '0001',
        2 => '0010',
        3 => '0011',
        4 => '0100',
        5 => '0101',
        6 => '0110',
        7 => '0111',
        8 => '1000',
        9 => '1001',
        'a' => '1010',
        'b' => '1011',
        'c' => '1100',
        'd' => '1101',
        'e' => '1110',
        'f' => '1111',
    ];
    $out = '';
    for ($i = 0; $i < strlen($string); $i++) {
        $out .= str_replace(['0', '1'], ['.', '_'], $map[$string[$i]]);
    }
    return str_split($out);
}
