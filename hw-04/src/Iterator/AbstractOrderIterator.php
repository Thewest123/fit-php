<?php

namespace Iterator;

use Node;

abstract class AbstractOrderIterator implements \Iterator
{
    // TODO: shared attributes?

    /**
     * AbstractOrderIterator constructor.
     *
     * @param Node $root
     */
    public function __construct(Node $root)
    {
    }

    public function current()
    {
        // TODO: Implement current() method.
    }

    public function next()
    {
        // TODO: Implement next() method.
    }

    public function key()
    {
        // TODO: Implement key() method.
    }

    public function valid()
    {
        // TODO: Implement valid() method.
    }

    public function rewind()
    {
        // TODO: Implement rewind() method.
    }
}
