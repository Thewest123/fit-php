<?php declare(strict_types=1);

// TODO implement and register autoloader

// Don't do anything with the following code, it is just for testing your solution.

function treeToString($iterator): string
{
    $values = [];
    foreach ($iterator as $node) {
        $values[] = $node->getValue();
    }
    return implode(' ', $values);
}

function printTreeResult($label, $result): void
{
    echo "  - $label " . ($result ? '✓' : '×') . PHP_EOL;
}

function testTrees($order, $getIterator): bool|int
{
    $result = true;
    for ($i = 1; $i <= TREE_COUNT; $i++) {
        $tree = "tree$i";
        $expected = "tree$i$order";
        global $$tree;
        global $$expected;
        $testResult = treeToString($getIterator($$tree)) === $$expected;
        printTreeResult("$tree ($order-order)", $testResult);
        $result &= $testResult;
    }
    return $result;
}

require_once('./trees.php');


// Test autoloader
echo "*> Autoloader ..." . PHP_EOL;
$classes = ['\\Node', 'Iterator\\InOrderIterator', 'Iterator\\PreOrderIterator', 'Iterator\\PostOrderIterator'];
$allExists = array_reduce($classes, static function ($acc, $class) {
    return $acc && class_exists($class, true);
}, true);
echo '=> ' . ($allExists ? 'OK [1]' : 'FAILED') . PHP_EOL;


// Test in-order iterator
echo PHP_EOL . "*> In-Order Iterator ..." . PHP_EOL;
$inOrderOk = testTrees('in', static function ($n) {
    return new Iterator\InOrderIterator($n);
});
echo '=> ' . ($inOrderOk ? 'OK [2]' : 'FAILED') . PHP_EOL;


// Test pre- and post-order iterators
echo PHP_EOL . "*> Pre- and Post-Order Iterators ..." . PHP_EOL;
$preOrderOk = testTrees('pre', static function ($n) {
    return new Iterator\PreOrderIterator($n);
});
$postOrderOk = testTrees('post', static function ($n) {
    return new Iterator\PostOrderIterator($n);
});
echo '=> ' . ($preOrderOk && $postOrderOk ? 'OK [2]' : 'FAILED') . PHP_EOL;


// Test IteratorAggregate
echo PHP_EOL . "*> IteratorAggregate ..." . PHP_EOL;
$iteratorAggregateOk = testTrees('in', static function ($n) {
    return $n;
});
echo '=> ' . ($iteratorAggregateOk ? 'OK [2]' : 'FAILED') . PHP_EOL;
