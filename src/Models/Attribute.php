<?php

namespace App\Models;

use App\Database\DBConnection;
use PDO;

class Attribute {
    protected $table = 'attributes';

    // Fetch an attribute by ID
    public static function getAttributeById($id) {
        $pdo = DBConnection::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM attributes WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Fetch all attributes
    public static function getAllAttributes() {
        $pdo = DBConnection::getConnection();
        $stmt = $pdo->query("SELECT * FROM attributes");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function createAttribute($id, $name, $type) {
        $pdo = DBConnection::getConnection();
        $stmt = $pdo->prepare("
            INSERT INTO attributes (id, name, type) 
            VALUES (:id, :name, :type)
        ");
        $stmt->execute([
            'id' => $id,
            'name' => $name,
            'type' => $type,
        ]);
    }
}
