<?php

namespace App\Models;

use PDO;
use PDOException;
use Exception;

class Price extends SearchableModel {
    protected static $table = 'prices';


    public static function create($data) {
        if (empty(static::$table)) {
            throw new Exception('Table not found');
        }
        try {
            $currencyId  = Currency::firstOrCreate("label",$data['currency']);
            $pdo = static::getConnection();
            $data['amount'] = round($data['amount'], 2);
            $sql = 'SELECT * FROM ' . static::$table . ' WHERE productId = :productId and ROUND(amount, 2) = :amount and currencyId = :currencyId';
            $stmt = $pdo->prepare($sql);
            error_log($currencyId);
            error_log(print_r($data,true));
            $stmt->execute(['productId' => $data['productId'], 'amount' => $data['amount'], 'currencyId' => $currencyId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            error_log("-------------------");
            error_log(print_r($result,true));
            if ($result) {
                return $result;
            } else {
                $sql = "INSERT INTO " . static::$table . " (productId, amount, currencyId) VALUES (:productId, :amount, :currencyId)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['productId' => $data['productId'], 'amount' => $data['amount'], 'currencyId' => $currencyId]);
                return $pdo->lastInsertId();
            }
            
        
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
        } catch (Exception $e) {
            error_log('General error: ' . $e->getMessage());
        }
    }
    
}