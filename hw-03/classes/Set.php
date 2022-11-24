<?php

include_once "Bag.php";

class Set extends Bag
{
    public function add(mixed $item): void
    {
        if (parent::contains($item))
            return;

        parent::add($item);
    }

    public function elementSize(mixed $item): int
    {
        return parent::contains($item) ? 1 : 0;
    }
}
