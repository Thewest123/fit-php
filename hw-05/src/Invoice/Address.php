<?php declare(strict_types=1);

namespace App\Invoice;

class Address
{
    protected string $street;

    protected string $number;

    protected string $city;

    protected string $zipCode;

    protected ?string $phone;

    protected ?string $email;

    public function getStreet(): string
    {
        return $this->street;
    }

    public function setStreet(string $street): Address
    {
        $this->street = $street;
        return $this;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function setNumber(string $number): Address
    {
        $this->number = $number;
        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): Address
    {
        $this->city = $city;
        return $this;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): Address
    {
        $this->zipCode = $zipCode;
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): Address
    {
        $this->phone = $phone;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): Address
    {
        $this->email = $email;
        return $this;
    }
}
