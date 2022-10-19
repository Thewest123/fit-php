<?php declare(strict_types=1);

use Iterator\AbstractOrderIterator;
use Iterator\InOrderIterator;

class Node implements IteratorAggregate
{
    protected ?Node $left = null;
    protected ?Node $right = null;

    public function __construct(protected int $value)
    {
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getLeft(): ?Node
    {
        return $this->left;
    }

    public function setLeft(?Node $left): Node
    {
        $this->left = $left;
        return $this;
    }

    public function getRight(): ?Node
    {
        return $this->right;
    }

    public function setRight(?Node $right): Node
    {
        $this->right = $right;
        return $this;
    }

    public function getIterator(): AbstractOrderIterator
    {
        return new InOrderIterator($this);
    }
}
