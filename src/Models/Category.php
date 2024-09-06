<?php

namespace App\Models;

use App\Database\DBConnection;
use PDO;
use PDOException;
use Exception;

class Category {
    protected $table = 'categories';

    // Fetch a category by ID
    public static function getCategoryById($id) {
        try{
        $pdo = DBConnection::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            throw $e; // Rethrow exception to be caught by outer catch block
        } catch (Exception $e) {
            error_log('General error: ' . $e->getMessage());
            throw $e; // Rethrow exception to be caught by outer catch block
        }
    }

    public static function getCategoryByName($name) {
        try {
        $pdo = DBConnection::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM categories WHERE name = :name");
        $stmt->execute(['name' => $name]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            throw $e; // Rethrow exception to be caught by outer catch block
        } catch (Exception $e) {
            error_log('General error: ' . $e->getMessage());
            throw $e; // Rethrow exception to be caught by outer catch block
        }
    }

    // Fetch all categories
    public static function getAllCategories() {
        $pdo = DBConnection::getConnection();
        $stmt = $pdo->query("SELECT * FROM categories");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch all products belonging to a category
    public static function getCategoryProducts($categoryId) {
        $pdo = DBConnection::getConnection();
        $stmt = $pdo->prepare("
            SELECT * FROM products 
            WHERE category_id = :categoryId
        ");
        $stmt->execute(['categoryId' => $categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Create a new category
    public static function createCategory($name) {
        try {
            $pdo = DBConnection::getConnection();
            $stmt = $pdo->prepare("
                INSERT INTO categories (name) 
                VALUES (:name)
            ");
            $stmt->execute([
                'name' => $name,
            ]);
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            throw $e; // Rethrow exception to be caught by outer catch block
        } catch (Exception $e) {
            error_log('General error: ' . $e->getMessage());
            throw $e; // Rethrow exception to be caught by outer catch block
        }
    }
}