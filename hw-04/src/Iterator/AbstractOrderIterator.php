<?php declare(strict_types=1);

namespace Iterator;

use Node;

abstract class AbstractOrderIterator implements \Iterator
{
    protected Node $rootNode;
    protected ?Node $currentNode;

    protected \SplStack $stack;

    public function __construct(Node $root)
    {
        $this->rootNode = $root;
    }

    public function current(): ?Node
    {
        return $this->currentNode;
    }

    public abstract function next(): void;

    public function key(): bool|int|float|string|null
    {
        return $this->current()->getValue();
    }

    public function valid(): bool
    {
        return $this->current() !== null;
    }

    public abstract function rewind(): void;
}
