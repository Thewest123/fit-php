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
            id INTEGER PRIMARY KEY,
            num TEXT,
            code TEXT
        )');
    }

    /**
     * Drops DB table using DROP TABLE ...
     */
    public static function dropTable(): void
    {
        $db = Db::get();
        $db->query('DROP TABLE IF EXISTS `account`');
    }

    /**
     * Find account record by number and bank code
     */
    public static function find(string $number, string $code): ?self
    {
        $db = Db::get();

        // Build query
        $query = 'SELECT id FROM `account` WHERE num = :num AND code = :code';
        $state = $db->prepare($query);

        // Validate and execute
        if (!$state) return null;

        if (!$state->execute([
            "num" => $number,
            "code" => $code,
            ])) return null;

        // Fetch result
        $result = $state->fetch();

        // Check result
        if (empty($result)) return null;

        // Return new instance of Account
        return new Account(intval($result["id"]), $number, $code);
    }

    /**
     * Find account record by id
     */
    public static function findById(int $id): ?self
    {
        $db = Db::get();

        // Build query
        $query = 'SELECT id, num, code FROM `account` WHERE id = :id';
        $state = $db->prepare($query);

        // Validate and execute
        if (!$state) return null;
        if (!$state->execute(["id" => $id])) return null;

        // Fetch result
        $result = $state->fetch();

        // Check result
        if (empty($result)) return null;

        // Return new instance of Account
        return new Account(intval($result["id"]), $result["num"], $result["code"]);
    }

    /**
     * Inserts new account record and returns its instance; or returns existing account instance
     */
    public static function findOrCreate(string $number, string $code): self
    {
        // Check existing
        $existing = self::find($number, $code);
        if ($existing !== null) return $existing;

        // Create new
        $db = Db::get();
        $query = 'INSERT INTO `account` (num, code) VALUES (:num, :code)';
        $state = $db->prepare($query);

        $state->execute([
            "num" => $number,
            "code" => $code
        ]);

        $id = intval($db->lastInsertId("account"));

        // Return new instance
        return new Account($id, $number, $code);
    }

    /**
     * Returns iterable of Transaction instances related to this Account, consider both transaction direction
     *
     * @return iterable<Transaction>
     */
    public function getTransactions(): iterable
    {
        $db = Db::get();

        // Build query
        $query = 'SELECT * FROM `transaction` WHERE account_from = :id OR account_to = :id';
        $state = $db->prepare($query);

        // Validate and execute
        if (!$state) return null;
        if (!$state->execute(["id" => $this->getId()])) return null;

        // Fetch result
        $result = $state->fetchAll();
        $transactions = [];

        foreach ($result as $item)
        {
            $from = Account::findById($item["account_from"]);
            $to = Account::findById($item["account_to"]);
            $transactions[] = new Transaction($from, $to, floatval($item["amount"]));
        }

        return $transactions;
    }

    /**
     * Returns transaction sum (using SQL aggregate function). Treat outgoing transactions as 'minus' and incoming as 'plus'.
     */
    public function getTransactionSum(): float
    {
        $db = Db::get();

        // --- OUTGOING ---
        // Build query
        $query = 'SELECT SUM(amount) FROM `transaction` WHERE account_from == :acc_from;';
        $state = $db->prepare($query);

        // Validate and execute
        if (!$state) return 0.0;
        if (!$state->execute(["acc_from" => $this->getId()])) return 0.0;

        // Fetch result
        $outgoingSum = floatval($state->fetch()[0]);

        // --- INCOMING ---
        // Build query
        $query = 'SELECT SUM(amount) FROM `transaction` WHERE account_to == :acc_to;';
        $state = $db->prepare($query);

        // Validate and execute
        if (!$state) return 0.0;
        if (!$state->execute(["acc_to" => $this->getId()])) return 0.0;

        // Fetch result
        $incomingSum = floatval($state->fetch()[0]);

        // Return
        return $incomingSum - $outgoingSum;
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
