<?php

namespace App\Models;

use App\Database\DBConnection;
use PDO;
use PDOException;
use Exception;

class Product {
    protected $table = 'products';

    // Fetch a product by ID
    public static function getProductById($id) {
        $pdo = DBConnection::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Fetch all products
    public static function getAllProducts() {
        $pdo = DBConnection::getConnection();
        $stmt = $pdo->query("SELECT * FROM products");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Create a new product
    public static function createProduct($id, $name, $description, $inStock, $category, $brand, $prices, $gallery, $attributes) {
        try {
            

            $pdo = DBConnection::getConnection();
            $pdo->beginTransaction(); // Start transaction
    
            // Verify category
            $categoryData = Category::getCategoryByName($category);
            if (!$categoryData) {
                // Create category using provided data
                Category::createCategory($category); // Use the category name
                // Retrieve the newly created category ID
                $categoryData = Category::getCategoryByName($category);
                error_log(print_r($categoryData, true));
            }
            $categoryID = $categoryData['id']; // Extract the ID

            $all = Category::getAllCategories();
            if (!$categoryData) {
                throw new Exception("Failed to retrieve category after creation.");
            }
            
            // Insert product details
            $stmt = $pdo->prepare("
            INSERT INTO products (id, name, description, inStock, category_id, brand) 
            VALUES (:id, :name, :description, :inStock, :category, :brand)
            ");
            $stmt->execute([
                'id' => $id,
                'name' => $name,
                'description' => $description,
                'inStock' => $inStock,
                'category' => $categoryID,
                'brand' => $brand,
            ]);
            
            
            // Insert prices
            $stmt = $pdo->prepare("
            INSERT INTO product_prices (product_id, amount, currency_label, currency_symbol) 
            VALUES (:product_id, :amount, :currency_label, :currency_symbol)
            ");
            
            foreach ($prices as $price) {
                $stmt->execute([
                    'product_id' => $id,
                    'amount' => $price['amount'],
                    'currency_label' => $price['currency']['label'],
                    'currency_symbol' => $price['currency']['symbol'],
                ]);
            }
            
            error_log('attr: ' . print_r($attributes, true));
            // Insert attributes
            foreach ($attributes as $attributeSet) {
                // Ensure attribute exists
                $attributeData = Attribute::getAttributeById($attributeSet['id']);
                error_log('attrDataid: ' . print_r($attributeSet['id'], true));

                if (!$attributeData) {
                    // Create the attribute if it doesn't exist
                    Attribute::createAttribute($attributeSet['id'], $attributeSet['name'], $attributeSet['type']);
                }

                // Insert each attribute item
                $stmt = $pdo->prepare("
                    INSERT INTO product_attributes (product_id, attribute_id, displayvalue) 
                    VALUES (:product_id, :attribute_id, :displayvalue)
                ");
                foreach ($attributeSet['items'] as $item) {
                    $stmt->execute([
                        'product_id' => $id,
                        'attribute_id' => $attributeSet['id'],
                        'displayvalue' => $item['displayValue'],
                    ]);
                }
            }
    
            $pdo->commit(); // Commit transaction
        } catch (PDOException $e) {
            $pdo->rollBack(); // Rollback transaction on error
            error_log('Database error: ' . $e->getMessage());
            throw $e; // Rethrow exception to be caught by outer catch block
        } catch (Exception $e) {
            $pdo->rollBack(); // Rollback transaction on error
            error_log('General error: ' . $e->getMessage());
            throw $e; // Rethrow exception to be caught by outer catch block
        }
    }


    // Fetch all attributes related to a product
    public static function getProductAttributes($productId) {
        $pdo = DBConnection::getConnection();
        $stmt = $pdo->prepare("
            SELECT attributes.* FROM attributes
            JOIN product_attributes ON attributes.id = product_attributes.attribute_id
            WHERE product_attributes.product_id = :productId
        ");
        $stmt->execute(['productId' => $productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch all prices related to a product
    public static function getProductPrices($productId) {
        $pdo = DBConnection::getConnection();
        $stmt = $pdo->prepare("
            SELECT * FROM product_prices
            WHERE product_id = :productId
        ");
        $stmt->execute(['productId' => $productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
