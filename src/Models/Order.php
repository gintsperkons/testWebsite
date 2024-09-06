<?php

namespace App\Models;

use App\Database\DBConnection;
use PDO;

class Order {
    protected $table = 'orders';

    // Fetch an order by ID
    public static function getOrderById($id) {
        $pdo = DBConnection::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Fetch all orders
    public static function getAllOrders() {
        $pdo = DBConnection::getConnection();
        $stmt = $pdo->query("SELECT * FROM orders");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Create a new order
    public static function createOrder($productId, $quantity, $totalPrice) {
        $pdo = DBConnection::getConnection();
        $stmt = $pdo->prepare("
            INSERT INTO orders (product_id, quantity, total_price) 
            VALUES (:product_id, :quantity, :total_price)
        ");
        $stmt->execute([
            'product_id' => $productId,
            'quantity' => $quantity,
            'total_price' => $totalPrice,
        ]);

        return [
            'id' => $pdo->lastInsertId(),
            'product_id' => $productId,
            'quantity' => $quantity,
            'total_price' => $totalPrice,
        ];
    }
}
