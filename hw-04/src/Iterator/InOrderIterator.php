<?php declare(strict_types=1);

namespace Iterator;

class InOrderIterator extends AbstractOrderIterator
{
    public function rewind(): void
    {
        $this->currentNode = $this->rootNode;
        $this->stack = new \SplStack();

        while ($this->currentNode !== null)
        {
            $this->stack->push($this->currentNode);
            $this->currentNode = $this->currentNode->getLeft();
        }

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

        if ($this->currentNode->getRight() !== null)
        {
            $next = $this->currentNode->getRight();
            while($next !== null)
            {
                $this->stack->push($next);
                $next = $next->getLeft();
            }
        }
    }
}
