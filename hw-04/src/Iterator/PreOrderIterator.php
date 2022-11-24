<?php declare(strict_types=1);

namespace Iterator;

class PreOrderIterator extends AbstractOrderIterator
{
    public function rewind(): void
    {
        $this->currentNode = $this->rootNode;
        $this->stack = new \SplStack();

        if ($this->currentNode !== null)
            $this->stack->push($this->currentNode);

        $this->next();
    }

    public function next(): void
    {
        if ($this->stack->isEmpty())
        {
            $this->currentNode = null;
            return;
        }

        $this->currentNode = $this->stack->top();
        $this->stack->pop();

        if($this->currentNode->getRight() !== null)
            $this->stack->push($this->currentNode->getRight());

        if($this->currentNode->getLeft() !== null)
            $this->stack->push($this->currentNode->getLeft());

    }
}
