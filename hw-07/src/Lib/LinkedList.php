<?php declare(strict_types=1);

namespace HW\Lib;

class LinkedList
{
    protected ?LinkedListItem $first = null;

    protected ?LinkedListItem $last = null;

    public function getFirst(): ?LinkedListItem
    {
        return $this->first;
    }

    public function setFirst(?LinkedListItem $first): LinkedList
    {
        $this->first = $first;
        return $this;
    }

    public function getLast(): ?LinkedListItem
    {
        return $this->last;
    }

    public function setLast(?LinkedListItem $last): LinkedList
    {
        $this->last = $last;
        return $this;
    }

    /**
     * Place new item at the beginning of the list
     */
    public function prependList(string $value): LinkedListItem
    {
        $item = new LinkedListItem($value);
        $second = $this->getFirst();
        $this->setFirst($item);

        // Check if list was empty, we can't setPrev() on null
        if ($second === null)
        {
            return $item;
        }

        $item->setNext($second);
        $second->setPrev($item);

        return $item;
    }

    /**
     * Place new item at the end of the list
     */
    public function appendList(string $value): LinkedListItem
    {
        $item = new LinkedListItem($value);
        $penultimate = $this->getLast();
        $this->setLast($item);

        // Check if list was empty, we can't setNext() on null
        if ($penultimate === null)
        {
            return $item;
        }

        $penultimate->setNext($item);
        $item->setPrev($penultimate);

        return $item;
    }

    /**
     * Insert item before $nextItem and maintain continuity
     */
    public function prependItem(LinkedListItem $nextItem, string $value): LinkedListItem
    {
        $item = new LinkedListItem($value);
        $item->setNext($nextItem);
        $item->setPrev($nextItem->getPrev());
        $nextItem->getPrev()?->setNext($item); //swap
        $nextItem->setPrev($item); //swap

        return $item;
    }

    /**
     * Insert item after $prevItem and maintain continuity
     */
    public function appendItem(LinkedListItem $prevItem, string $value): LinkedListItem
    {
        $item = new LinkedListItem($value);
        $item->setPrev($prevItem);
        $item->setNext($prevItem->getNext()); //swap
        $prevItem->setNext($item); //swap
        $item->getNext()?->setPrev($item); //$item->getNext

        return $item;
    }
}
