<?php

namespace App\Models;

use PDO;
use PDOException;
use Exception;

class Attribute extends BaseModel {
    protected static $table = 'attribute';

    public static function create($data) {
        if (empty(static::$table)) {
            throw new Exception('Table not found');
        }
        try {
            $pdo = static::getConnection();
            $sql = 'SELECT * FROM ' . static::$table . ' WHERE attributeSetId = :attributeSetId and attId = :attId and value = :value and displayValue = :displayValue';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['attributeSetId' => $data['attributeSetId'], 'attId' => $data['attId'], 'value' => $data['value'], 'displayValue' => $data['displayValue']]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return $result;
            } else {
                parent::create($data);
                return $pdo->lastInsertId();
            }
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
        } catch (Exception $e) {
            error_log('General error: ' . $e->getMessage());
        }
    }

}