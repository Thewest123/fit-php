<?php declare(strict_types=1);

namespace App;

use App\Invoice\Address;
use App\Invoice\BusinessEntity;
use App\Invoice\Item;

class Builder
{
    protected Invoice $invoice;
    protected BusinessEntity $supplier;
    protected BusinessEntity $customer;

    protected string $number;

    /** @var Item[] */
    protected array $items;

    public function build(): Invoice
    {
        $this->invoice = new Invoice();

        $this->invoice->setSupplier($this->supplier);
        $this->invoice->setCustomer($this->customer);
        $this->invoice->setNumber($this->number);

        foreach($this->items as $item)
        {
            $this->invoice->addItem($item);
        }

        return $this->invoice;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function setSupplier(
        string  $name,
        string  $vatNumber,
        string  $street,
        string  $number,
        string  $city,
        string  $zip,
        ?string $phone = null,
        ?string $email = null
    ): self
    {
        $address = new Address();
        $address->setStreet($street);
        $address->setNumber($number);
        $address->setCity($city);
        $address->setZipCode($zip);
        $address->setPhone($phone);
        $address->setEmail($email);

        $this->supplier = new BusinessEntity();
        $this->supplier->setName($name);
        $this->supplier->setVatNumber($vatNumber);
        $this->supplier->setAddress($address);

        return $this;
    }

    public function setCustomer(
        string  $name,
        string  $vatNumber,
        string  $street,
        string  $number,
        string  $city,
        string  $zip,
        ?string $phone = null,
        ?string $email = null
    ): self
    {
        $address = new Address();
        $address->setStreet($street);
        $address->setNumber($number);
        $address->setCity($city);
        $address->setZipCode($zip);
        $address->setPhone($phone);
        $address->setEmail($email);

        $this->customer = new BusinessEntity();
        $this->customer->setName($name);
        $this->customer->setVatNumber($vatNumber);
        $this->customer->setAddress($address);

        return $this;
    }

    public function addItem(string $description, ?float $quantity, ?float $price): self
    {
        if ($quantity === NULL)
            $quantity = 0;

        if ($price === NULL)
            $price = 0;

        $item = new Item();

        $item->setDescription($description);
        $item->setQuantity($quantity);
        $item->setUnitPrice($price);

        $this->items[] = $item;

        return $this;
    }
}
