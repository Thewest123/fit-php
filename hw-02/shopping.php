<?php declare(strict_types=1);

function getPrice(string $item): float {
    // TODO
}

/**
 * @param string[] $list
 * @return string[]
 */
function sortList(array $list): array {
    // TODO
}

/**
 * @param string[] $list
 */
function sumList(array $list): float {
    // TODO
}

if (count($argv) !== 2) {
	echo "Usage: php shopping.php <input>" . PHP_EOL;
	exit(1);
}
$input = trim(file_get_contents(end($argv)));
$list = explode(PHP_EOL, $input);
$list = sortList($list);
print_r($list);
print_r(sumList($list) . PHP_EOL);
