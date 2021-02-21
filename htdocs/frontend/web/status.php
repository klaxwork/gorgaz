<?php
$f = fopen('status.log', 'a');
$tm = time() - microtime(true);
$t = strftime('%Y-%m-%d %H:%M:%S');
$time4file = print_r($t, true);
fputs($f, "\t{$time4file} + {$tm}\n");

print '$_GET => ';
print_r($_GET);
print "\n\n";

print '$_POST => ';
print_r($_POST);
print "\n\n";

fputs($f, '$_GET => ' . print_r($_GET, true) . "\n\n");
fputs($f, '$_POST => ' . print_r($_POST, true) . "\n\n");

foreach ($_POST as $key => $value) {
    $x = print_r($key, true);
    fputs($f, '$key = ' . $x);

    fputs($f, "\n-------------------------\n\n");

    $x = print_r($value, true);
    fputs($f, '$value = ' . $x);

    $str = $key . print_r($value, true);
    fputs($f, 'STR = ' . $str);

}
fclose($f);
?>