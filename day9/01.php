<?php

//$line = "{{<a!>},{<a!>},{<a!>},{<ab>}}";
//$line = "{{<!!>},{<!!>},{<!!>},{<!!>}}";
//$line = "{{<ab>},{<ab>},{<ab>},{<ab>}}";
//$line = "{<a>,<a>,<a>,<a>}";
//$line = "{{{},{},{{}}}}";
//$line = '<{o"i!a,<{i<a>';

$line = file_get_contents('input');


$line = preg_replace("/\!(.?)/", "", $line);
$matches = [];
preg_match_all("/\<([^\>]*)\>/i", $line, $matches);
$letterCount = 0;
foreach ($matches[1] as $match) {
    $match = str_replace('!', '', $match);
    $letterCount += strlen($match);
}

$line = preg_replace("/\<([^\>]*)\>/", '"x"', $line);
$line = str_replace(['{}', '{', '}'], ['{"x"}', '[', ']'], $line);

$json = json_decode($line, true);
echo 'P1: ' . recurseCount($json) . "\n";
echo 'P2: ' . $letterCount . "\n";


function recurseCount($data, $lvl = 1)
{
    $sum = $lvl;
    if (is_array($data)) {
        foreach ($data as $line) {
            if (is_array($line)) {
                $sum += recurseCount($line, $lvl + 1);
            }
        }
    }
//    echo $lvl . ' => ' . $sum . "\n";
    return $sum;
}