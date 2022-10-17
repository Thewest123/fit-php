<?php declare(strict_types=1);

namespace App;

class Builder
{
    protected Invoice $invoice;

    public function build(): Invoice
    {
        // TODO implement
    }

    public function setNumber(string $number): self
    {
        // TODO implement
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
        // TODO implement
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
        // TODO implement
    }

    public function addItem(string $description, ?float $quantity, ?float $price): self
    {
        // TODO implement
    }
}
