<?php declare(strict_types=1);

namespace App\Invoice;

class Item
{
    protected string $description;

    protected float $quantity = 1.0;

    protected float $unitPrice;

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): Item
    {
        $this->description = $description;
        return $this;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): Item
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getUnitPrice(): float
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(float $unitPrice): Item
    {
        $this->unitPrice = $unitPrice;
        return $this;
    }

    public function getTotalPrice(): float|int
    {
        // TODO implement calculation
    }
}
