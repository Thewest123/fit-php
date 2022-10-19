<?php declare(strict_types=1);

namespace Iterator;

use Node;

abstract class AbstractOrderIterator implements \Iterator
{
    // TODO: shared attributes?
    protected Node $rootNode;
    protected ?Node $currentNode;

    protected \SplStack $stack;

    public function __construct(Node $root)
    {
        // TODO: Implement constructor.
        $this->rootNode = $root;
        //$this->buildStack();
    }

    public function current(): ?Node
    {
        // TODO: Implement current() method.
        return $this->currentNode;
    }

    public abstract function next(): void;
    //{
        // TODO: Implement next() method.
    //}

    public function key(): bool|int|float|string|null
    {
        // TODO: Implement key() method.
        return $this->current()->getValue();
    }

    public function valid(): bool
    {
        // TODO: Implement valid() method.
        return $this->current() !== null;
    }

    public abstract function rewind(): void;
}
