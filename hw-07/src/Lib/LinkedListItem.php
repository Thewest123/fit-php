<?php declare(strict_types=1);

namespace HW\Lib;

class LinkedListItem
{
    protected string $value;

    protected ?LinkedListItem $next = null;

    protected ?LinkedListItem $prev = null;

    /**
     * LinkedListItem constructor.
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): LinkedListItem
    {
        $this->value = $value;
        return $this;
    }

    public function getNext(): ?LinkedListItem
    {
        return $this->next;
    }

    public function setNext(?LinkedListItem $next): LinkedListItem
    {
        $this->next = $next;
        return $this;
    }

    public function getPrev(): ?LinkedListItem
    {
        return $this->prev;
    }

    public function setPrev(?LinkedListItem $prev): LinkedListItem
    {
        $this->prev = $prev;
        return $this;
    }
}
