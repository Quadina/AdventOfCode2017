<?php

$input =
    "     |          
     |  +--+    
     A  |  C    
 F---|----E|--+ 
     |  |  |  D 
     +B-+  +--+ 
                
                ";
$start = [0, 5];

$input = file_get_contents('input');
$start = [0, 1];

$lines = explode("\n", $input);
$map = array_map(function ($v) {
    return str_split($v);
}, $lines);


$letters = [];
$steps = 0;
go($map, $start, 'down', $letters);
echo implode(', ', $letters) . "\n";
echo 'steps: ' . $steps . "\n";

function go($map, $position, $direction, &$letters)
{
    global $steps;
    $char = $map[$position[0]][$position[1]];
    if ($char == ' ') {
        return;
    }
    $steps++;
    if (!in_array($char, ['-', '|', '+', ' '])) {
        $letters[] = $char;
    }
    if ($char == "+") {
        switch ($direction) {
            case 'right':
            case 'left':
                if (!isset($map[$position[0] - 1][$position[1]]) || $map[$position[0] - 1][$position[1]] == ' ') {
                    $newDirection = 'down';
                    $newPosition = [$position[0] + 1, $position[1]];
                } else {
                    $newDirection = 'up';
                    $newPosition = [$position[0] - 1, $position[1]];
                }
                break;
            case 'up':
            default:
            case 'down':
                if (!isset($map[$position[0]][$position[1] - 1]) || $map[$position[0]][$position[1] - 1] == ' ') {
                    $newDirection = 'right';
                    $newPosition = [$position[0], $position[1] + 1];
                } else {
                    $newDirection = 'left';
                    $newPosition = [$position[0], $position[1] - 1];
                }
        }
//        echo " $direction+$newDirection ";
        return go($map, $newPosition, $newDirection, $letters);
    } else {
        switch ($direction) {
            case 'right':
                $newPosition = [$position[0], $position[1] + 1];
                $newChar = $map[$position[0]][$position[1] + 1];
                break;
            case 'left':
                $newPosition = [$position[0], $position[1] - 1];
                $newChar = $map[$position[0]][$position[1] - 1];
                break;
            case 'up':
                $newPosition = [$position[0] - 1, $position[1]];
                $newChar = $map[$position[0] - 1][$position[1]];
                break;
            case 'down':
                $newPosition = [$position[0] + 1, $position[1]];
                $newChar = $map[$position[0] + 1][$position[1]];
        }
//        echo implode(',', $newPosition) . ' ';
    }
    go($map, $newPosition, $direction, $letters);
}

function mapDump($map, $position)
{
    foreach ($map as $x => $line) {
        foreach ($line as $y => $row) {
            echo $row . ($position[0] == $x && $position[1] == $y ? '>' : ' ');
        }
        echo "\n";
    }
}