<?php

$input = "pbga (66)
xhth (57)
ebii (61)
havc (66)
ktlj (57)
fwft (72) -> ktlj, cntj, xhth
qoyq (66)
padx (45) -> pbga, havc, qoyq
tknk (41) -> ugml, padx, fwft
jptl (61)
ugml (68) -> gyxo, ebii, jptl
gyxo (61)
cntj (57)";

$input = file_get_contents("input");

$array = explode("\n", $input);
$mapa = [];
$left = [];
$right = [];

array_map(function ($n) use (&$mapa, &$left, &$right) {
    $head = trim(strtok($n, " "));
    $mapa[$head]['weight'] = (int)trim(strtok(")"), '\(\)');
    if (stripos($n, '>') > 0) {
        $mapa[$head]['node'] = explode(', ', trim(explode(">", $n)[1]));
    } else {
        $mapa[$head]['node'] = [];
    }
    $left[$head] = $head;
    foreach ($mapa[$head]['node'] as $val) {
        $right[$val] = trim($val);
    }
}, $array);

$rootKey = current(array_diff($left, $right));
echo 'Part 1: ' . $rootKey . "\n";

function sumWeight($root, $mapa)
{
    $weight = $mapa[$root]['weight'];
    $weights = [];
    foreach ($mapa[$root]['node'] as $node) {
        $weights[$node] = sumWeight($node, $mapa);
        $weight += $weights[$node];
    }
    if (count($weights)) {
        $max = max($weights);
        $min = min($weights);
        $maxKey = array_search($max, $weights);
        $minkey = array_search($min, $weights);
        $diff = ($weights[$maxKey] - $weights[$minkey]);
        if ($diff > 0) {
            echo $root . ' => ' . ($mapa[$maxKey]['weight'] - $diff) . "\n";
        }
    }
    return $weight;
}

var_dump(sumWeight($rootKey, $mapa));