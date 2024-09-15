<?php 

namespace App\Models;

use Attribute;
use PDO;
use PDOException;
use Exception;
use App\Models\Attribute as AttributeModel;


class Orders extends SearchableModel {
    protected static $table = 'orders';

    public static function create($data) {
        error_log('Creating order');
        try {
            // Log the input data for debugging
            error_log(print_r($data, true));
            
            $pdo = static::getConnection();
            $pdo->beginTransaction();
            
            // Calculate the total amount for the order and get currency ID
            $totalAmount = 0;
            $currencySymbol = null;
            $currencyId = null;

            foreach ($data as $item) {
                $productData = Product::getByTextId($item['productId']);
                if ($productData) {
                    $price = $productData['prices'][0]['amount'];
                    $currencySymbol = $productData['prices'][0]['currency']['symbol'];
                    $totalAmount += $price * $item['quantity'];
                } else {
                    throw new Exception('Product not found');
                }
            }

            // Fetch or set the currency ID based on the currency symbol
            error_log('Currency symbol: ' . $currencySymbol);
            if ($currencySymbol) {
                $currency = Currency::getByForeignKey('symbol', $currencySymbol)[0];
                if ($currency) {
                    $currencyId = $currency['id'];
                } else {
                    throw new Exception('Currency not found');
                }
            }
            if ($currencyId === null) {
                throw new Exception('Currency ID is required');
            }

            // Insert into the orders table
            $sql = "INSERT INTO orders (totalAmount, currencyId, status) VALUES (:totalAmount, :currencyId, :status)";
            $stmt = $pdo->prepare($sql);
            
            $status = 'ordered'; // Set the initial status
            
            $stmt->execute([
                'totalAmount' => $totalAmount,
                'currencyId' => $currencyId,
                'status' => $status,
            ]);
            // Get the last inserted order ID
            $orderId = $pdo->lastInsertId();
            
            // Insert order products
            $sql = "INSERT INTO orderProducts (orderId, productId, quantity, price) VALUES (:orderId, :productId, :quantity, :price)";
            $stmt = $pdo->prepare($sql);

            foreach ($data as $item) {
                $productData = Product::getByTextId($item['productId']);
                $price = $productData['prices'][0]['amount']; 
                // Insert each product
                $stmt->execute([
                    'orderId' => $orderId,
                    'productId' => $productData['numId'],
                    'quantity' => $item['quantity'],
                    'price' => $price,
                ]);

                $orderProductId = $pdo->lastInsertId();
                
            
                // Insert order attributes
                if (!empty($item['selectedAttributes'])) {
                    $sql = "INSERT INTO orderAttributes (orderProductId, attributeId) VALUES (:orderProductId, :attributeId)";
                    $stmt = $pdo->prepare($sql);
                    foreach ($item['selectedAttributes'] as $attribute) {
                        error_log('Attribute: ' . print_r($attribute, true));
                        $setId = AttributeSet::getByValues(["productId" => $productData['numId'], "setId" => $attribute['attributeId']]);
                        error_log(print_r($setId, true));
                        error_log(print_r(["attributeSetId" => $setId['id'], "attId" => $attribute['valueId']], true));
                        $attributeId = AttributeModel::getByValues(["attributeSetId" => $setId['id'], "attId" => $attribute['valueId']]);
                        
                        error_log('Attribute ID: ' . $productData['numId']);
                        error_log('Attribute ID: ' . $attributeId['id']);
                        try {
                            $stmt->execute([
                                'orderProductId' => $orderProductId,
                                'attributeId' => $attributeId['id'],
                            ]);
                            error_log('Attribute inserted');
                        } catch (PDOException $e) {
                            error_log('Execution error: ' . $e->getMessage());
                        }
                        
                    }
                }
            }
            
            // Commit transaction
            $pdo->commit();
            return $orderId; // Return the created order ID
    
        } catch (PDOException $e) {
            // Rollback transaction if something went wrong
            $pdo->rollBack();
            error_log('Database error: ' . $e->getMessage());
            throw new Exception('Database error');
        } catch (Exception $e) {
            // Rollback transaction if something went wrong
            $pdo->rollBack();
            error_log('General error: ' . $e->getMessage());
            throw new Exception('General error');
        }
    }
}
