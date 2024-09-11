<?php

namespace App\Models;

use PDO;
use PDOException;
use Exception;

abstract class SearchableModel extends BaseModel
{

    // Method to get a record by 'name' column
    public static function getByName($name)
    {
        if (empty(static::$table)) {
            throw new Exception('Table not defined');
        }

        try {
            $pdo = static::getConnection();
            $stmt = $pdo->prepare("SELECT * FROM " . static::$table . " WHERE name = :name");
            $stmt->execute(['name' => $name]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
        } catch (Exception $e) {
            error_log('General error: ' . $e->getMessage());
        }
    }

    public static function deleteByName($name)
    {
        if (empty(static::$table)) {
            throw new Exception('Table not defined');
        }

        try {
            $pdo = static::getConnection();
            $stmt = $pdo->prepare("DELETE FROM " . static::$table . " WHERE name = :name");
            $stmt->execute(['name' => $name]);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
        } catch (Exception $e) {
            error_log('General error: ' . $e->getMessage());
        }
    }

    public static function firstOrCreate($fieldTitle, $data) {
        error_log(print_r($fieldTitle,true));
        error_log(print_r($data,true));
        error_log(print_r($data[$fieldTitle],true));
        $query = "SELECT * FROM " . static::$table . " WHERE " . $fieldTitle . " = :fieldValue";
        $pdo = static::getConnection();
        $stmt = $pdo->prepare($query);
        $stmt->execute(['fieldValue' => $data[$fieldTitle]]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        
        if ($result) {
            return $result['id'];
        } else {
            
            return static::create($data);
        }
    }
}