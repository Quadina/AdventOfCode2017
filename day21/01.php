<?php

$input = "../.# => ##./#../...
.#./..#/### => #..#/..../..../#..#";
$input = file_get_contents('input');

$rulesRaw = explode("\n", $input);
$rules = [];

foreach ($rulesRaw as $rule) {
    list($left, $right) = explode(' => ', $rule);
    $left = trim($left);
    $right = trim($right);
    $rules[$left] = $right;

    $tmp = exlMap(trim($left));
    $rules = flipMap($tmp, $right, $rules);

    $rot = rotate90($tmp);
    $rules = flipMap($rot, $right, $rules);
    $rot = rotate90($rot);
    $rules = flipMap($rot, $right, $rules);
    $rot = rotate90($rot);
    $rules = flipMap($rot, $right, $rules);
}
//var_dump($rules);
//die();

$start = ".#./..#/###";
$maps[0] = exlMap($start);

for ($iteration = 0; $iteration < 18; $iteration++) {
    foreach ($maps as $key => $map) {
        if (count($map) % 2 == 0) {
            $fragment = joinMap($map);
            $maps[] = exlMap($rules[$fragment]);
            unset($maps[$key]);
        } elseif (count($map) % 3 == 0) {
            $fragment = joinMap(getFragment($map, 0, 0, 3));
            $exl = exlMap($rules[$fragment]);
            $maps[] = getFragment($exl, 0, 0, 2);
            $maps[] = getFragment($exl, 2, 0, 2);
            $maps[] = getFragment($exl, 0, 2, 2);
            $maps[] = getFragment($exl, 2, 2, 2);
            unset($maps[$key]);
        }
    }
}
echo 'p1: ' . countOnMap($maps);

function countOnMap($maps, $string = "#")
{
    $sum = 0;
    foreach ($maps as $map) {
        foreach ($map as $line) {
            echo implode("", $line) . " ";
            foreach ($line as $row) {
                if ($row == $string) {
                    $sum++;
                }
            }
        }
        echo "\n";
    }
    return $sum;
}

function getFragment($map, $x, $y, $size)
{
    $arr = [];
    for ($i = $x; $i < $x + $size; $i++) {
        for ($j = $y; $j < $y + $size; $j++) {
            $arr[$i - $x][$j - $y] = $map[$i][$j];
        }
    }
    return $arr;
}

function exlMap($map)
{
    $lines = explode("/", $map);
    foreach ($lines as &$line) {
        $line = str_split($line);
    }
    return $lines;
}

function joinMap($map)
{
    if (!is_array($map)) {
        var_dump($map);
        die();
    }
    if (is_array(current($map))) {
        $arr = [];
        foreach ($map as $line) {
            $arr[] = implode($line);
        }
        return implode("/", $arr);
    }
    return implode("/", $map);
}

function rotate90($matrix)
{
    array_unshift($matrix, null);
    $matrix = call_user_func_array('array_map', $matrix);
    return array_map('array_reverse', $matrix);
}

function flipMap($tmp, $right, $rules)
{
    if (count($tmp) == 2) {
        $ll = [[$tmp[0][1], $tmp[0][0]], [$tmp[1][1], $tmp[1][0]]];
        $rules[joinMap($ll)] = trim($right);
        $ll = [[$tmp[1][1], $tmp[1][0]], [$tmp[0][1], $tmp[0][0]]];
        $rules[joinMap($ll)] = trim($right);
        $ll = [[$tmp[1][0], $tmp[1][1]], [$tmp[0][0], $tmp[0][1]]];
        $rules[joinMap($ll)] = trim($right);
    }
    if (count($tmp) == 3) {
        $ll = [[$tmp[0][2], $tmp[0][1], $tmp[0][0]], [$tmp[1][2], $tmp[1][1], $tmp[1][0]], [$tmp[2][2], $tmp[2][1], $tmp[2][0]]];
        $rules[joinMap($ll)] = trim($right);
        $ll = [[$tmp[2][2], $tmp[2][1], $tmp[2][0]], [$tmp[1][2], $tmp[1][1], $tmp[1][0]], [$tmp[0][2], $tmp[0][1], $tmp[0][0]]];
        $rules[joinMap($ll)] = trim($right);
        $ll = [[$tmp[2][0], $tmp[2][1], $tmp[2][2]], [$tmp[1][0], $tmp[1][1], $tmp[1][2]], [$tmp[0][0], $tmp[0][1], $tmp[0][2]]];
        $rules[joinMap($ll)] = trim($right);
    }
    return $rules;
}