<?php declare(strict_types=1);

namespace Iterator;

use Node;

abstract class AbstractOrderIterator implements \Iterator
{
    // TODO: shared attributes?

    public function __construct(Node $root)
    {
        // TODO: Implement constructor.
    }

    public function current(): ?Node
    {
        // TODO: Implement current() method.
    }

    public function next(): void
    {
        // TODO: Implement next() method.
    }

    public function key(): bool|int|float|string|null
    {
        // TODO: Implement key() method.
    }

    public function valid(): bool
    {
        // TODO: Implement valid() method.
    }

    public function rewind(): void
    {
        // TODO: Implement rewind() method.
    }
}
