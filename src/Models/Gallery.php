<?php

namespace App\Models;

use PDO;
use PDOException;
use Exception;

class Gallery extends BaseModel {
    protected static $table = 'gallery';

    public static function create($data) {
        if (empty(static::$table)) {
            throw new Exception('Table not found');
        }
        try {
            $pdo = static::getConnection();
            $sql = 'SELECT * FROM ' . static::$table . ' WHERE productId = :productId and imagePath = :imagePath';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['productId' => $data['productId'], 'imagePath' => $data['imagePath']]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return $result;
            } else {
                $sql = "INSERT INTO " . static::$table . " (productId, imagePath) VALUES (:productId, :imagePath)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['productId' => $data['productId'], 'imagePath' => $data['imagePath']]);
                return $pdo->lastInsertId();
            }
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
        } catch (Exception $e) {
            error_log('General error: ' . $e->getMessage());
        }
    }



}