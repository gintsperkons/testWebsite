<?php

namespace App\Models;

use App\Database\DBConnection;
use PDO;
use PDOException;
use Exception;

abstract class BaseModel {
    protected static $table = '';

    //Get database Connenction


    protected static function getConnection() {
        return DBConnection::getConnection();
    }

    public static function getById($id) {
        if (empty(static::$table)) {
            throw new Exception('Table not found');
        }

        try {
            $pdo = static::getConnection();
            $stmt = $pdo->prepare("SELECT * FROM " . static::$table . " WHERE id = :id");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
        } catch (Exception $e) {
            error_log('General error: ' . $e->getMessage());
        }
    }


    public static function getAll() {
        if (empty(static::$table)) {
            throw new Exception('Table not found');
        }

        try {
            $pdo = static::getConnection();
            $stmt = $pdo->query("SELECT * FROM " . static::$table);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
        } catch (Exception $e) {
            error_log('General error: ' . $e->getMessage());
        }
    }

    public static function create($data) {
        if (empty(static::$table)) {
            throw new Exception('Table not found');
        }

  


        try {
            $pdo = static::getConnection();
            $columns = implode(', ', array_keys($data));
            $placeholders = ':' . implode(', :', array_keys($data));
            $sql = "INSERT INTO " . static::$table . " ($columns) VALUES ($placeholders)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($data);
            return $pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
        } catch (Exception $e) {
            error_log('General error: ' . $e->getMessage());
        }
    }

    public static function update($id, $data) {
        if (empty(static::$table)) {
            throw new Exception('Table not found');
        }

        try {
            $pdo = static::getConnection();
            $columns = '';
            foreach (array_keys($data) as $key) {
                $columns .= $key . ' = :' . $key . ', ';
            }
            $columns = rtrim($columns, ', ');
            $data['id'] = $id;
            $sql = "UPDATE " . static::$table . " SET $columns WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($data);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
        } catch (Exception $e) {
            error_log('General error: ' . $e->getMessage());
        }
    }

    public static function delete($id) {
        if (empty(static::$table)) {
            throw new Exception('Table not found');
        }

        try {
            $pdo = static::getConnection();
            $stmt = $pdo->prepare("DELETE FROM " . static::$table . " WHERE id = :id");
            $stmt->execute(['id' => $id]);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
        } catch (Exception $e) {
            error_log('General error: ' . $e->getMessage());
        }
    }

    public static function getByForeignKey($foreignKey, $id) {
        if (empty(static::$table)) {
            throw new Exception('Table not found');
        }

        try {
            $pdo = static::getConnection();
            $stmt = $pdo->prepare("SELECT * FROM " . static::$table . " WHERE " . $foreignKey . " = :id");
            $stmt->execute(['id' => $id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
        } catch (Exception $e) {
            error_log('General error: ' . $e->getMessage());
        }
    }

}