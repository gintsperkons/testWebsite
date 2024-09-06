<?php

namespace App\Controller;

use GraphQL\GraphQL as GraphQLBase;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;
use GraphQL\Type\SchemaConfig;
use RuntimeException;
use Throwable;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;

class GraphQL
{
    static public function handle()
    {
        header('Content-Type: application/json; charset=UTF-8');

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(204);
            exit();
        }

        // Define Product Type
        $productType = new ObjectType([
            'name' => 'Product',
            'fields' => [
                'id' => Type::string(),
                'name' => Type::string(),
                'description' => Type::string(),
                'inStock' => Type::boolean(),
                'category' => Type::string(),
                'brand' => Type::string(),
                'prices' => [
                    'type' => Type::listOf(new ObjectType([
                        'name' => 'Price',
                        'fields' => [
                            'amount' => Type::float(),
                            'currency' => new ObjectType([
                                'name' => 'Currency',
                                'fields' => [
                                    'label' => Type::string(),
                                    'symbol' => Type::string(),
                                ],
                            ]),
                        ],
                    ])),
                ],
                'gallery' => Type::listOf(Type::string()),
                'attributes' => [
                    'type' => Type::listOf(new ObjectType([
                        'name' => 'AttributeSet',
                        'fields' => [
                            'id' => Type::string(),
                            'name' => Type::string(),
                            'type' => Type::string(),
                            'items' => [
                                'type' => Type::listOf(new ObjectType([
                                    'name' => 'Attribute',
                                    'fields' => [
                                        'id' => Type::string(),
                                        'displayValue' => Type::string(),
                                        'value' => Type::string(),
                                    ],
                                ])),
                            ],
                        ],
                    ])),
                ],
            ],
        ]);

        // Define Category Type
        $categoryType = new ObjectType([
            'name' => 'Category',
            'fields' => [
                'name' => Type::string(),
            ],
        ]);

        // Define Order Type
        $orderType = new ObjectType([
            'name' => 'Order',
            'fields' => [
                'id' => Type::int(),
                'product_id' => Type::string(),
                'quantity' => Type::int(),
                'total_price' => Type::float(),
            ],
        ]);

        // Define Product Input Type
        $productInputType = new InputObjectType([
            'name' => 'ProductInput',
            'fields' => [
                'id' => ['type' => Type::nonNull(Type::string())],
                'name' => ['type' => Type::nonNull(Type::string())],
                'description' => ['type' => Type::string()],
                'inStock' => ['type' => Type::nonNull(Type::boolean())],
                'category' => ['type' => Type::nonNull(Type::string())],
                'brand' => ['type' => Type::string()],
                'prices' => [
                    'type' => Type::listOf(new InputObjectType([
                        'name' => 'PriceInput',
                        'fields' => [
                            'amount' => ['type' => Type::nonNull(Type::float())],
                            'currency' => new InputObjectType([
                                'name' => 'CurrencyInput',
                                'fields' => [
                                    'label' => ['type' => Type::nonNull(Type::string())],
                                    'symbol' => ['type' => Type::nonNull(Type::string())],
                                ],
                            ]),
                        ],
                    ])),
                ],
                'gallery' => ['type' => Type::listOf(Type::string())],
                'attributes' => [
                    'type' => Type::listOf(new InputObjectType([
                        'name' => 'AttributeSetInput',
                        'fields' => [
                            'id' => ['type' => Type::nonNull(Type::string())],
                            'name' => ['type' => Type::nonNull(Type::string())],
                            'type' => ['type' => Type::nonNull(Type::string())],
                            'items' => [
                                'type' => Type::listOf(new InputObjectType([
                                    'name' => 'AttributeInput',
                                    'fields' => [
                                        'id' => ['type' => Type::nonNull(Type::string())],
                                        'displayValue' => ['type' => Type::nonNull(Type::string())],
                                        'value' => ['type' => Type::nonNull(Type::string())],
                                    ],
                                ])),
                            ],
                        ],
                    ])),
                ],
            ],
        ]);

        // Define Query Type
        $queryType = new ObjectType([
            'name' => 'Query',
            'fields' => [
                'categories' => [
                    'type' => Type::listOf($categoryType),
                    'resolve' => static function () {
                        return Category::getAllCategories();
                    },
                ],
                'products' => [
                    'type' => Type::listOf($productType),
                    'resolve' => static function () {
                        return Product::getAllProducts();
                    },
                ],
                'product' => [
                    'type' => $productType,
                    'args' => [
                        'id' => ['type' => Type::nonNull(Type::string())],
                    ],
                    'resolve' => static function ($root, $args) {
                        return Product::getProductById($args['id']);
                    },
                ],
                'orders' => [
                    'type' => Type::listOf($orderType),
                    'resolve' => static function () {
                        return Order::getAllOrders();
                    },
                ],
                'order' => [
                    'type' => $orderType,
                    'args' => [
                        'id' => ['type' => Type::nonNull(Type::int())],
                    ],
                    'resolve' => static function ($root, $args) {
                        return Order::getOrderById($args['id']);
                    },
                ],
            ],
        ]);

        // Define Mutation Type
        $mutationType = new ObjectType([
            'name' => 'Mutation',
            'fields' => [
                'createOrder' => [
                    'type' => $orderType,
                    'args' => [
                        'product_id' => ['type' => Type::nonNull(Type::string())],
                        'quantity' => ['type' => Type::nonNull(Type::int())],
                        'total_price' => ['type' => Type::nonNull(Type::float())],
                    ],
                    'resolve' => static function ($root, $args) {
                        return Order::createOrder($args['product_id'], $args['quantity'], $args['total_price']);
                    },
                ],
                'createProduct' => [
                    'type' => $productType,
                    'args' => [
                        'productInput' => ['type' => $productInputType],
                    ],
                    'resolve' => static function ($root, $args) {
                        try {
                            $productInput = $args['productInput'];
                            return Product::createProduct(
                                $productInput['id'],
                                $productInput['name'],
                                $productInput['description'],
                                $productInput['inStock'],
                                $productInput['category'],
                                $productInput['brand'],
                                $productInput['prices'],
                                $productInput['gallery'],
                                $productInput['attributes']
                            );
                        } catch (Exception $e) {
                            error_log('GraphQL Error: ' . $e->getMessage());
                            throw new RuntimeException('Internal server error'); // or more specific error message
                        }
                    },
                ],
            ],
        ]);

        // Define Schema
        $schema = new Schema(
            (new SchemaConfig())
                ->setQuery($queryType)
                ->setMutation($mutationType)
        );

        // Process Request
        try {
            $rawInput = file_get_contents('php://input');
            if ($rawInput === false) {
                throw new RuntimeException('Failed to get php://input');
            }

            $input = json_decode($rawInput, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new RuntimeException('Failed to decode JSON: ' . json_last_error_msg());
            }

            $query = $input['query'] ?? null;
            $variableValues = $input['variables'] ?? null;

            $rootValue = [];
            $result = GraphQLBase::executeQuery($schema, $query, $rootValue, null, $variableValues);
            $output = $result->toArray();
        } catch (Throwable $e) {
            error_log('GraphQL error: ' . $e->getMessage());
            $output = [
                'error' => [
                    'message' => $e->getMessage(),
                ],
            ];
        }

        echo json_encode($output);
    }
}
