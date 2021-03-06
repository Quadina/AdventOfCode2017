<?php
include "BigInteger.php";

$varA = new Math_BigInteger(516);
$varB = new Math_BigInteger(190);

//$varA = new Math_BigInteger(65);
//$varB = new Math_BigInteger(8921);

$multiA = new Math_BigInteger(16807);
$multiB = new Math_BigInteger(48271);

$divider = new Math_BigInteger(2147483647);

$counter = 0;
$max = 40000000;
/**
 * @param $varA
 * @param $multiA
 * @param $divider
 * @return mixed
 */
function generate(Math_BigInteger $varA, Math_BigInteger $multiA, Math_BigInteger $divider)
{
    list($dupa, $varA) = $varA->multiply($multiA)->divide($divider);
    return $varA;
}

for ($i = 0; $i < $max; $i++) {
    $varA = generate($varA, $multiA, $divider);
    $varB = generate($varB, $multiB, $divider);
    $stringA = str_pad(decbin($varA->toString()), 32, "0", STR_PAD_LEFT);
    $stringB = str_pad(decbin($varB->toString()), 32, "0", STR_PAD_LEFT);

    if (substr($stringA, 16) == substr($stringB, 16)) {
        $counter++;
    }
    if ($i % 100000 == 0) echo floor($i / $max * 100) . ' ';
}

echo 'p1: ' . $counter . "\n";

