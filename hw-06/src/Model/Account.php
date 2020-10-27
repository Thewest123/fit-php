<?php declare(strict_types=1);

namespace App\Model;

use App\Db;

class Account
{
    /** @var integer */
    protected $id;

    /** @var string */
    protected $number;

    /** @var string */
    protected $code;

    /**
     * Account constructor.
     *
     * @param int $id
     * @param string $number
     * @param string $code
     */
    public function __construct(int $id, string $number, string $code)
    {
        $this->id = $id;
        $this->number = $number;
        $this->code = $code;
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
     *
     * @param string $number
     * @param string $code
     * @return Account|null
     */
    public static function find(string $number, string $code): ?self
    {
        // TODO implement
    }

    /**
     * Find account record by id
     * 
     * @param int $id
     * @return static|null
     */
    public static function findById(int $id): ?self
    {
        // TODO implement
    }

    /**
     * Inserts new account record and returns its instance; or returns existing account instance
     *
     * @param string $number
     * @param string $code
     * @return static
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
     *
     * @return float
     */
    public function getTransactionSum(): float
    {
        // TODO implement
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Account
     */
    public function setId(int $id): Account
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @param string $number
     * @return Account
     */
    public function setNumber(string $number): Account
    {
        $this->number = $number;

        return $this;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return Account
     */
    public function setCode(string $code): Account
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Account string representation
     *
     * @return string
     */
    public function __toString()
    {
        return "{$this->number}/{$this->code}";
    }
}
