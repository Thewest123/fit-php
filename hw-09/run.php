<?php declare(strict_types=1);

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

require __DIR__ . '/vendor/autoload.php';

const ALZA_BASE = "https://www.alza.cz";
const ALZA_PREFIX = "/search.htm?exps=";

const CZC_BASE = "https://www.czc.cz/";
const CZC_SUFFIX = "/hledat";

const DELAY = 1; // seconds
const PRODUCT_LIMIT = 3; // how many products to scrape from search

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

    // Init client
    $client = new Client();

    // -------------------------------- Alza.cz --------------------------------
    // Get crawler of current page
    $crawler = $client->request('GET', ALZA_BASE . ALZA_PREFIX . $query);

    // Get items
    $i = 0;
    $crawler->filter("#boxes > .box.browsingitem")->each(
        function (Crawler $node) use (&$results, &$client, &$i)
        {
            $i++;
            if ($i > 3)
                return;

            $name = $node->filter("a.name")->text();
            $price = $node->filter(".price span.price-box__price")->text();
            $link = ALZA_BASE . $node->filter("a.name")->attr("href");
            $eshop = "Alza.cz";

            $descCrawler = $client->request('GET', $link);
            $description = $descCrawler->filter("#detailItem #detailText span")->text();

            $results[] = [
                "name" => $name,
                "price" => $price,
                "link" => $link,
                "eshop" => $eshop,
                "description" => $description
            ];

            print("Scraped item {$i} on Alza.cz: " . $name . PHP_EOL);


            sleep(1);
        }
    );

    // ---------------------------------- CZC ----------------------------------
    // Get crawler of current page
    $crawler = $client->request('GET', CZC_BASE . $query . CZC_SUFFIX);

    // Get items
    $i = 0;
    $crawler->filter("#tiles > .new-tile")->each(
        function (Crawler $node) use (&$results, &$client, &$i)
        {
            $i++;
            if ($i > 3)
                return;

            $name = $node->filter(".tile-title a")->text();
            $price = $node->filter(".total-price span.price > span.price-vatin")->text();
            $link = CZC_BASE . $node->filter(".tile-title a")->attr("href");
            $eshop = "CZC";

            $descCrawler = $client->request('GET', $link);
            $description = $descCrawler->filter(".pd-info p.pd-shortdesc")->text();

            // Remove "Další informace" link at the end of the description
            $description = str_replace("Další informace", "", $description);

            $results[] = [
                "name" => $name,
                "price" => $price,
                "link" => $link,
                "eshop" => $eshop,
                "description" => $description
            ];

            print("Scraped item {$i} on CZC: " . $name . PHP_EOL);

            sleep(1);
        }
    );

    return $results;
}

/**
 * @param string $query - query string e.g. 'Beats Studio 3'
 * @param array $results - input product collection
 * @return array
 */
function filter(string $query, array $results): array
{
    // Filter bad results
    $filtered = array_filter($results,
        function($item) use (&$query)
        {
            if (stripos($item["name"], $query) === FALSE && stripos($item["description"], $query) === FALSE)
                return false;

            return true;
        }
    );

    // Sort by price descending
    usort($filtered,
        function($a, $b)
        {
            // Remove non numbers
            $priceA = intval(preg_replace('/[^0-9]/', '', $a["price"]));
            $priceB = intval(preg_replace('/[^0-9]/', '', $b["price"]));

            return $priceA < $priceB;
        }
    );

    return $filtered;
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
