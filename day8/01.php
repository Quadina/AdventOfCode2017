<?php

error_reporting(E_ALL);

$input = "b inc 5 if a > 1
a inc 1 if b < 5
c dec -10 if a >= 1
c inc -20 if c == 10";

$input = file_get_contents('input');

$lines = explode("\n", $input);

$variables = [];
$maxVariable = 0;

foreach ($lines as $line) {
    list($v1, $op, $v2, $if, $v3, $cond, $num) = explode(" ", $line);

    switch ($cond) {
        case '>':
            if (val($v3) > $num) {
                dispatchOperation($v1, $op, $v2);
            }
            break;
        case '>=':
            if (val($v3) >= $num) {
                dispatchOperation($v1, $op, $v2);
            }
            break;
        case '<':
            if (val($v3) < $num) {
                dispatchOperation($v1, $op, $v2);
            }
            break;
        case '<=':
            if (val($v3) <= $num) {
                dispatchOperation($v1, $op, $v2);
            }
            break;
        case '==':
            if (val($v3) == $num) {
                dispatchOperation($v1, $op, $v2);
            }
            break;
        case '!=':
            if (val($v3) != $num) {
                dispatchOperation($v1, $op, $v2);
            }
            break;
    }
}

echo "max: " . max($variables) . "\n";
echo "maxLocal: " . $maxVariable . "\n";

function dispatchOperation($v1, $op, $v2)
{
    global $variables, $maxVariable;
    if ($op == 'inc') {
        $variables[$v1] = val($v1) + $v2;
    } else {
        $variables[$v1] = val($v1) - $v2;
    }
    $maxLocal = max($variables);
    if ($maxLocal > $maxVariable) {
        $maxVariable = $maxLocal;
    }
}

function val($name)
{
    global $variables;
    return isset($variables[$name]) ? $variables[$name] : 0;
}