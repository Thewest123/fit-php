<?php declare (strict_types=1);

class Bag {

    private array $items = [];

    public function add(mixed $item): void
    {
        $this->items[] = $item;
    }

    public function clear(): void
    {
        $this->items = [];
    }

    public function contains(mixed $item): bool
    {
        $doesContain = false;

        foreach ($this->items as $existingItem)
        {
            if ($existingItem === $item)
            {
                $doesContain = true;
                break;
            }
        }

        return $doesContain;
    }

    public function elementSize(mixed $item): int
    {
        $count = array_count_values($this->items);
        return $count[$item] ?? 0;
    }

    public function isEmpty(): bool
    {
        return $this->size() === 0;
    }

    public function remove(mixed $item): void
    {
        foreach ($this->items as $index => $existingItem)
        {
            if ($existingItem === $item) {
                unset($this->items[$index]);
                break;
            }
        }
    }

    public function size(): int
    {
        return count($this->items);
    }
}
