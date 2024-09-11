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
            error_log('Creatin13g product');

            error_log(print_r($data['prices'],true));
            foreach ($data['prices'] as $price) {
                error_log(print_r($price,true));
                Price::create(['productId' => $prodId, 'amount' => $price['amount'], 'currency' => $price['currency']]);
            }
            error_log('Creatin357g product');

            foreach ($data['attributes'] as $attribute) {
                $attribute['productId'] = $prodId;
                AttributeSet::create($attribute);
            }



            $pdo->commit();
           // return $pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
        } catch (Exception $e) {
            error_log('General error: ' . $e->getMessage());
        }


        //$lastInsertId = parent::create($data);
        //return $lastInsertId;
    }

    public static function getAll() {
        $products = parent::getAll();
        foreach ($products as $key => $product) {
            $products[$key]['brand'] = Brand::getById($product['brandId'])['name'];
            $products[$key]['category'] = Category::getById($product['categoryId'])['name'];

            $products[$key]['gallery'] = array();
            $gallery = Gallery::getByForeignKey('productId',$product['id']);
            foreach ($gallery as $image) { // Use $imageKey instead of $key
                array_push($products[$key]['gallery'], $image['imagePath']);
            }

            $products[$key]['prices'] = array();
            $prices = Price::getByForeignKey('productId',$product['id']);
            foreach ($prices as $price) {
                $currency = Currency::getById($price['currencyId']);
                unset($currency['id']);
                array_push($products[$key]['prices'], ['amount' => $price['amount'], 'currency' => $currency]);
            }

            $products[$key]['attributes'] = array();
            $attributeSets = AttributeSet::getByForeignKey('productId',$product['id']);
            foreach ($attributeSets as $attributeSet) {
                $attributes = Attribute::getByForeignKey('attributeSetId',$attributeSet['id']);
                    $items = Attribute::getByForeignKey('attributeSetId',$attributeSet['id']);
                    foreach ($items as $item) {
                        $item['id'] = $item['attId'];
                        unset($item['attId']);
                        unset($item['attributeSetId']);
                    }
                    error_log(print_r( $attributeSet,true));
                    $attributeSet['id'] = $attributeSet['setId'];
                    unset($attributeSet['setId']);
                    unset($attributeSet['productId']);
                    $attributeSet['items'] = $items;
                    array_push($products[$key]['attributes'], $attributeSet);
                    
                
            }

        }
        return $products;
    }
}