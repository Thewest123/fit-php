<?php declare(strict_types=1);

namespace Books\Database;

use PDO;

class Database
{
    private const DSN = "sqlite:books.sqlite";
    private const USER = null;
    private const PASSWORD = null;

    private static ?PDO $pdo = null;

    public static function getConnection(): PDO
    {
        return self::$pdo ?? (self::$pdo = new PDO(
            self::DSN,
            self::USER,
            self::PASSWORD,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        ));
    }
}
