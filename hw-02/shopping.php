<?php declare(strict_types=1);

function getPrice(string $item): float {

    // RegEx match
    $pattern = "/CZK ?(\d+(?:\.?\d*)*,?\d*)|(\d+(?:\.?\d*)*,?\d*) ?(?:Kč?|CZK)|(\d+),-/";
    preg_match($pattern, $item, $matches);

    // Join match groups (except index 0)
    // We can do that, because the number can be in only one of the groups, others will be empty or null
    $priceString = join("", array_slice($matches, 1));

    // Remove dots between numbers
    $priceString = str_replace(".", "", $priceString);

    // Replace decimal comma with a dot
    $priceString = str_replace(",", ".", $priceString);

    return floatval($priceString);
}

/**
 * @param string $a First item to get price from
 * @param string $b Second item to get price from
 * @return int
 */
function priceCompare(string $a, string $b): int
{
    $result = 0;

    $priceA = getPrice($a);
    $priceB = getPrice($b);

    if ($priceA < $priceB)
        $result = 1;

    else if ($priceA > $priceB)
        $result = -1;

    return $result;
}

/**
 * @param string[] $list
 * @return string[]
 */
function sortList(array $list): array {
    usort($list, 'priceCompare');
    return $list;
}

/**
 * @param string[] $list
 */
function sumList(array $list): float {
    $sum = 0.0;

    foreach ($list as $item)
        $sum += getPrice($item);

    return $sum;
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
