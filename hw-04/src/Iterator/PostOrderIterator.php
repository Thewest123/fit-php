<?php declare(strict_types=1);

namespace Iterator;

use Node;

class PostOrderIterator extends AbstractOrderIterator
{
    private ?Node $lastNode = null;

    private function goBack(?Node $node): void
    {
        if ($node === null)
            return;

        while ($node !== null)
        {
            $this->stack->push($node);
            $node = $node->getLeft();
        }

        $this->goBack($this->stack->top()->getRight());
    }

    public function rewind(): void
    {
        $this->currentNode = $this->rootNode;
        $this->stack = new \SplStack();

        $this->goBack($this->currentNode);
        $this->lastNode = $this->stack->top();

        $this->next();
    }

    public function next(): void
    {
        if ($this->stack->isEmpty())
        {
            $this->currentNode = null;
            return;
        }

        if ($this->lastNode !== $this->stack->top()->getRight())
            $this->goBack($this->stack->top()->getRight());

        $this->currentNode = $this->stack->pop();
        $this->lastNode = $this->currentNode;
    }
}
