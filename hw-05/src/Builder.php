<?php declare(strict_types=1);


namespace App;

class Builder
{
    /** @var Invoice */
    protected $invoice;

    /**
     * @return Invoice
     */
    public function build(): Invoice
    {
        // TODO implement
    }

    /**
     * @param string $number
     * @return $this
     */
    public function setNumber(string $number): self
    {
        // TODO implement
    }


    /**
     * @param string      $name
     * @param string      $vatNumber
     * @param string      $street
     * @param string      $number
     * @param string      $city
     * @param string      $zip
     * @param string|null $phone
     * @param string|null $email
     * @return $this
     */
    public function setSupplier(
        string $name,
        string $vatNumber,
        string $street,
        string $number,
        string $city,
        string $zip,
        ?string $phone = null,
        ?string $email = null
    ): self {
        // TODO implement
    }

    /**
     * @param string      $name
     * @param string      $vatNumber
     * @param string      $street
     * @param string      $number
     * @param string      $city
     * @param string      $zip
     * @param string|null $phone
     * @param string|null $email
     * @return $this
     */
    public function setCustomer(
        string $name,
        string $vatNumber,
        string $street,
        string $number,
        string $city,
        string $zip,
        ?string $phone = null,
        ?string $email = null
    ): self {
        // TODO implement
    }

    /**
     * @param string     $description
     * @param float|null $quantity
     * @param float|null $price
     * @return $this
     */
    public function addItem(string $description, ?float $quantity, ?float $price): self
    {
        // TODO implement
    }
}
