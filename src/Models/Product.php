<?php

namespace App\Models;

use PDO;
use PDOException;
use Exception;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Gallery;

class Product extends SearchableModel {
    protected static $table = 'products';

    public static function create($data) {
        //insert brand if not exists
        //insert category
        //insert gallery 
        //insert price ==> currency
        //insert attributesSet ==> attribute
        if($data['inStock'] == '') {
            $data['inStock'] = 0;
        }
        
        try {
            $pdo = static::getConnection();
            $pdo->beginTransaction();

            $brand = Brand::firstOrCreate("name",['name' => $data['brand']]);
            $category = Category::firstOrCreate("name",[ 'name' => $data['category']]);
            $sql = "SELECT * FROM products WHERE productId = :productId";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['productId' => $data['id']]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $prodId = $result['id'];
            } else {
                $prodId = parent::create(['name' => $data['name'], 'brandId' => $brand, 'categoryId' => $category, 'description' => $data['description'], 'productId' => $data['id'],'inStock'=> $data['inStock']]);
            }

            foreach ($data['gallery'] as $image) {
                Gallery::create(['productId' => $prodId, 'imagePath' => $image]);
            }
            foreach ($data['prices'] as $price) {
                Price::create(['productId' => $prodId, 'amount' => $price['amount'], 'currency' => $price['currency']]);
            }
            foreach ($data['attributes'] as $attribute) {
                $attribute['productId'] = $prodId;
                AttributeSet::create($attribute);
            }
            error_log($data['id']);
            error_log($data['inStock']);
            error_log(is_numeric($data['inStock']));
            error_log('Cresdasdasdatin357g product');

            $pdo->commit();
            error_log($pdo->lastInsertId());
            return $pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
        } catch (Exception $e) {
            error_log('General error: ' . $e->getMessage());
        }


        //$lastInsertId = parent::create($data);
        //return $lastInsertId;
    }

    public static function getByCategory($category) {
        $category = Category::getByName($category);
        $products = parent::getByForeignKey('categoryId', $category['id']);
        $products = self::populateProductData($products);
        return $products;
    }

    public static function getById($id) {
        $product = parent::getById($id);
        $product = self::populateProductData([$product]);
        return $product[0];
    }

    public static function getAll() {
        $products = parent::getAll();
        $products = self::populateProductData($products);
        return $products;
    }


    public static function populateProductData($products) {
        foreach ($products as $key => $product) {
            // Get and set brand name
            $products[$key]['brand'] = Brand::getById($product['brandId'])['name'];
            
            // Get and set category name
            $products[$key]['category'] = Category::getById($product['categoryId'])['name'];
            
            // Get and set gallery images
            $products[$key]['gallery'] = array();
            $gallery = Gallery::getByForeignKey('productId', $product['id']);
            foreach ($gallery as $image) {
                $products[$key]['gallery'][] = $image['imagePath'];
            }
    
            // Get and set prices
            $products[$key]['prices'] = array();
            $prices = Price::getByForeignKey('productId', $product['id']);
            foreach ($prices as $price) {
                $currency = Currency::getById($price['currencyId']);
                unset($currency['id']);
                $products[$key]['prices'][] = ['amount' => $price['amount'], 'currency' => $currency];
            }
    
            // Get and set attributes
            $products[$key]['attributes'] = array();
            $attributeSets = AttributeSet::getByForeignKey('productId', $product['id']);
            foreach ($attributeSets as $attributeSet) {
                $attributes = Attribute::getByForeignKey('attributeSetId', $attributeSet['id']);
                $items = Attribute::getByForeignKey('attributeSetId', $attributeSet['id']);
                foreach ($items as $item) {
                    $item['id'] = $item['attId'];
                    unset($item['attId']);
                    unset($item['attributeSetId']);
                }
                $attributeSet['id'] = $attributeSet['setId'];
                unset($attributeSet['setId']);
                unset($attributeSet['productId']);
                $attributeSet['items'] = $items;
                $products[$key]['attributes'][] = $attributeSet;
            }
        }
        return $products;
    }
    
}