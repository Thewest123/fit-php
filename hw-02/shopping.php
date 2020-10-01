<?php

function getPrice($item) {
	// TODO
}

function sortList($list) {
	// TODO
}

function sumList($list) {
	// TODO
}

if (count($argv) !== 2) {
	echo "Usage: php shopping.php <input>\n";
	exit(1);
}
$input = file_get_contents(end($argv));
$list = explode(PHP_EOL, $input);
$list = sortList($list);
print_r($list);
print_r(sumList($list) . PHP_EOL);
