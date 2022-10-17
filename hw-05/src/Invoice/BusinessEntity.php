<?php declare(strict_types=1);

namespace App\Invoice;

class BusinessEntity
{
    protected string $name;

    protected string $vatNumber;

    protected Address $address;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): BusinessEntity
    {
        $this->name = $name;
        return $this;
    }

    public function getVatNumber(): string
    {
        return $this->vatNumber;
    }

    public function setVatNumber(string $vatNumber): BusinessEntity
    {
        $this->vatNumber = $vatNumber;
        return $this;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): BusinessEntity
    {
        $this->address = $address;
        return $this;
    }
}
