<?php

namespace App\Models;

use PDO;
use PDOException;
use Exception;

class AttributeSet extends BaseModel {
    protected static $table = 'attributeSet';

    public static function create($data) {
        if (empty(static::$table)) {
            throw new Exception('Table not found');
        }
        try {
            $pdo = static::getConnection();
            $sql = 'SELECT * FROM ' . static::$table . ' WHERE name = :name and type = :type and setId = :setId and productId = :productId';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['name' => $data['name'], 'type' => $data['type'], 'setId' => $data['id'], 'productId' => $data['productId']]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $atSetId = $result['id'];
            } else {
                $sql = "INSERT INTO " . static::$table . " (name, type, setId, productId) VALUES (:name, :type, :setId, :productId)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['name' => $data['name'], 'type' => $data['type'], 'setId' => $data['id'], 'productId' => $data['productId']]);
                $atSetId = $pdo->lastInsertId();
            }
            foreach ($data['items'] as $attribute) {
                $attribute['attributeSetId'] = $atSetId;
                $attribute['attId'] = $attribute['id'];
                unset($attribute['id']);
                Attribute::create($attribute);
            }
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
        } catch (Exception $e) {
            error_log('General error: ' . $e->getMessage());
        }
    }
}