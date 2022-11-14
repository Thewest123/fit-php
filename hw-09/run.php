<?php declare(strict_types=1);

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

require __DIR__ . '/vendor/autoload.php';

/**
 * @param Crawler $crawler
 * @param string $selector
 * @return string|null
 */
function text(Crawler $crawler, string $selector): ?string
{
    $new = $crawler->filter($selector);
    if (count($new)) {
        return trim($new->text());
    }

    return null;
}

/**
 * @param string $query - query string e.g. 'Beats Studio3'
 * @return array
 */
function scrape(string $query): array
{
    $results = [];

    // TODO implement scraping from at least two e-shops

    return $results;
}

/**
 * @param string $query - query string e.g. 'Beats Studio 3'
 * @param array $results - input product collection
 * @return array
 */
function filter(string $query, array $results): array
{
    // TODO implement irrelevant products filtering out
    return $results;
}

/**
 * @param array $results
 * @param bool $includeDescription
 * @return void
 * input array $results show contain following keys
 * - 'name'
 * - 'price'
 * - 'link' - link to product detail page
 * - 'eshop' - eshop identifier e.g. 'alza'
 * - 'description'
 */
function printResults(array $results, bool $includeDescription = false): void
{
    $width = [
        'name' => 0,
        'price' => 0,
        'link' => 0,
        'eshop' => 0,
        'description' => 0,
    ];
    foreach ($results as $result) {
        foreach ($result as $key => $value) {
            $width[$key] = max(mb_strlen($value), $width[$key]);
        }
    }
    echo '+' . str_repeat('-', 2 + $width['name']);
    echo '+' . str_repeat('-', 2 + $width['price']);
    echo '+' . str_repeat('-', 2 + $width['link']);
    echo '+' . str_repeat('-', 2 + $width['eshop']) . "+" . PHP_EOL;
    foreach ($results as $result) {

        echo '| ' . $result['name'] . str_repeat(' ', $width['name'] - mb_strlen($result['name'])) . ' ';
        echo '| ' . $result['price'] . str_repeat(' ', $width['price'] - mb_strlen($result['price'])) . ' ';
        echo '| ' . $result['link'] . str_repeat(' ', $width['link'] - mb_strlen($result['link'])) . ' ';
        echo '| ' . $result['eshop'] . str_repeat(' ', $width['eshop'] - mb_strlen($result['eshop'])) . ' ';
        echo "|" . PHP_EOL;
        echo '+' . str_repeat('-', 2 + $width['name']);
        echo '+' . str_repeat('-', 2 + $width['price']);
        echo '+' . str_repeat('-', 2 + $width['link']);
        echo '+' . str_repeat('-', 2 + $width['eshop']) . "+" . PHP_EOL;
        if ($includeDescription) {
            echo '| ' . $result['description'] . str_repeat(' ',
                    max(0, 7 + $width['name'] + $width['price'] + $width['link'] - mb_strlen($result['description'])));
            echo "|" . PHP_EOL;
            echo str_repeat('-', 10 + $width['name'] + $width['price'] + $width['link']) . PHP_EOL;
        }
    }
}

// MAIN
if (count($argv) !== 2) {
    echo "Usage: php run.php <query>" . PHP_EOL;
    exit(1);
}

$query = $argv[1];
$results = scrape($query);
$results = filter($query, $results);
printResults($results);
