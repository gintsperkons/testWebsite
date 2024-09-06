<?php

namespace App\Database;

use PDO;
use PDOException;

class DBConnection {
    private static $pdo;

    public static function getConnection() {
        if (self::$pdo === null) {
            $host = $_ENV['DB_HOST'];
            $dbname = $_ENV['DB_NAME'];
            $user = $_ENV['DB_USER'];
            $pass = $_ENV['DB_PASS'];
            
            try {
                self::$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Database connection failed: ' . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
