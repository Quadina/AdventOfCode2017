<?php
$input = "set a 1
add a 2
mul a a
mod a 5
snd a
set a 0
rcv a
jgz a -1
set a 1
jgz a -2";
$input = file_get_contents('input');

$lines = explode("\n", $input);
$values = [];
$lastPlayed = '';

$commands = [];
foreach ($lines as $line) {
    $commands[] = explode(" ", trim($line) . ' ');
}

for ($i = 0; $i < count($commands); $i++) {
    /** @var $param1 integer|string */
    /** @var $param2 integer|string */
    list($command, $param1, $param2) = $commands[$i];
    echo $i . "\t" . $command . "\t" . $param1 . "\t" . $param2 . "\t=> ";
    switch ($command) {
        case 'set':
            echo $values[$param1] = (is_numeric($param2) ? $param2 : $values[$param2]);
            break;
        case 'add';
            echo $values[$param1] += (is_numeric($param2) ? $param2 : $values[$param2]);
            break;
        case 'snd';
            $lastPlayed = (is_numeric($param1) ? $param1 : $values[$param1]);
            echo "Last Played: " . $lastPlayed;
            break;
        case 'mul';
            echo $values[$param1] *= is_numeric($param2) ? $param2 : $values[$param2];
            break;
        case 'mod';
            echo $values[$param1] %= (is_numeric($param2) ? $param2 : $values[$param2]);
            break;
        case 'rcv';
            $val = (is_numeric($param1) ? $param1 : $values[$param1]);
            if ($val != 0) {
                echo $lastPlayed . "\n";
                break 2;
            }
            break;
        case 'jgz';
            $val1 = (is_numeric($param1) ? $param1 : $values[$param1]);
            $val2 = (is_numeric($param2) ? $param2 : $values[$param2]);
            if ($val1 > 0) {
                $i = $i - 1 + $val2;
            }
            break;
    }
    echo "\n";
}

var_dump($values);