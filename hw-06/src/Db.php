<?php declare(strict_types=1);

namespace App;

use PDO;

class Db
{
    protected static ?PDO $pdo = null;

    public static function get(): PDO
    {
        return self::$pdo ?? (self::$pdo = new PDO(
            'sqlite:hw-06.db',
            null,
            null,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        ));
    }
}
