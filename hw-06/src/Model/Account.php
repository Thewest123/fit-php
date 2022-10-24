<?php declare(strict_types=1);

namespace App\Model;

use App\Db;

class Account
{
    public function __construct(
        protected int    $id,
        protected string $number,
        protected string $code
    )
    {
    }

    /**
     * Creates DB table using CREATE TABLE ...
     */
    public static function createTable(): void
    {
        $db = Db::get();
        $db->query('CREATE TABLE IF NOT EXISTS `account` (
            -- TODO implement
        )');
    }

    /**
     * Drops DB table using DROP TABLE ...
     */
    public static function dropTable(): void
    {
        // TODO implement
    }

    /**
     * Find account record by number and bank code
     */
    public static function find(string $number, string $code): ?self
    {
        // TODO implement
    }

    /**
     * Find account record by id
     */
    public static function findById(int $id): ?self
    {
        // TODO implement
    }

    /**
     * Inserts new account record and returns its instance; or returns existing account instance
     */
    public static function findOrCreate(string $number, string $code): self
    {
        // TODO implement
    }

    /**
     * Returns iterable of Transaction instances related to this Account, consider both transaction direction
     *
     * @return iterable<Transaction>
     */
    public function getTransactions(): iterable
    {
        // TODO implement
    }

    /**
     * Returns transaction sum (using SQL aggregate function). Treat outgoing transactions as 'minus' and incoming as 'plus'.
     */
    public function getTransactionSum(): float
    {
        // TODO implement
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Account
    {
        $this->id = $id;
        return $this;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function setNumber(string $number): Account
    {
        $this->number = $number;
        return $this;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): Account
    {
        $this->code = $code;
        return $this;
    }

    public function __toString(): string
    {
        return "{$this->number}/{$this->code}";
    }
}
