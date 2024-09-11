<?php

namespace App\Controller;

use Exception;
use GraphQL\GraphQL as GraphQLBase;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Schema;
use GraphQL\Error\Error;
use GraphQL\Type\SchemaConfig;
use RuntimeException;
use Throwable;

use App\Models\Category;
use App\Models\Product;

class GraphQL
{
    static public function handle()
    {
        //TODO make type for query return only needed based on data give because product deletion should handle the rest of item updating
        error_log("Separator -------------------");
        try {
            $testType = new ObjectType([
                'name' => 'Hello',
                'fields' => [
                    'hello' => [
                        'type' => Type::string(),
                        'resolve' => static fn($rootValue, array $args): string => 'world',
                    ],
                ],
            ]);

            $categoryType = new ObjectType([
                'name' => 'Category',
                'fields' => [
                    'id' => [
                        'type' => Type::int(),
                    ],
                    'name' => [
                        'type' => Type::string(),
                    ],
                ],
            ]);
            

            $currencyType = new ObjectType([
                'name' => 'Currency',
                'fields' => [
                    'label' => [
                        'type' => Type::string(),
                    ],
                    'symbol' => [
                        'type' => Type::string(),
                    ],
                ],
            ]);

            $priceType = new ObjectType([
                'name' => 'Price',
                'fields' => [
                    'amount' => [
                        'type' => Type::float(),
                    ],
                    'currency' => [
                        'type' => $currencyType,
                    ],
                ],
            ]);

            $attributeType = new ObjectType([
                'name' => 'Attribute',
                'fields' => [
                    'id' => [
                        'type' => Type::string(),
                    ],
                    'displayValue' => [
                        'type' => Type::string(),
                    ],
                    'value' => [
                        'type' => Type::string(),
                    ],
                ],
            ]);

            $attributeSetType = new ObjectType([
                'name' => 'AttributeSet',
                'fields' => [
                    'id' => [
                        'type' => Type::string(),
                    ],
                    'name' => [
                        'type' => Type::string(),
                    ],
                    'type' => [
                        'type' => Type::string(),
                    ],
                    'items' => [
                        'type' => Type::listOf($attributeType),
                    ],
                ],
            ]);

            $productType = new ObjectType([
                'name' => 'Product',
                'fields' => [
                    'id' => [
                        'type' => Type::int(),
                    ],
                    'name' => [
                        'type' => Type::string(),
                    ],
                    'inStock' => [
                        'type' => Type::boolean(),
                    ],
                    'description' => [
                        'type' => Type::string(),
                    ],
                    'category' => [
                        'type' => Type::string(),
                    ],
                    'brand' => [
                        'type' => Type::string(),
                    ],
                    'gallery' => [
                        'type' => Type::listOf(Type::string()),
                    ],
                    'prices' => [
                        'type' => Type::listOf($priceType),
                    ],
                    'attributes' => [
                        'type' => Type::listOf($attributeSetType),
                    ],
                ]
            ]);

            // Define CurrencyInput
            $currencyInputType = new InputObjectType([
                'name' => 'CurrencyInput',
                'fields' => [
                    'label' => [
                        'type' => Type::string(),
                    ],
                    'symbol' => [
                        'type' => Type::string(),
                    ],
                ],
            ]);

            // Define PriceInput
            $priceInputType = new InputObjectType([
                'name' => 'PriceInput',
                'fields' => [
                    'amount' => [
                        'type' => Type::float(),
                    ],
                    'currency' => [
                        'type' => $currencyInputType,
                    ],
                ],
            ]);

            // Define AttributeInput
            $attributeInputType = new InputObjectType([
                'name' => 'AttributeInput',
                'fields' => [
                    'id' => [
                        'type' => Type::string(),
                    ],
                    'displayValue' => [
                        'type' => Type::string(),
                    ],
                    'value' => [
                        'type' => Type::string(),
                    ],
                ],
            ]);

            // Define AttributeSetInput
            $attributeSetInputType = new InputObjectType([
                'name' => 'AttributeSetInput',
                'fields' => [
                    'id' => [
                        'type' => Type::string(),
                    ],
                    'name' => [
                        'type' => Type::string(),
                    ],
                    'type' => [
                        'type' => Type::string(),
                    ],
                    'items' => [
                        'type' => Type::listOf($attributeInputType),
                    ],
                ],
            ]);

            // Define ProductInput
            $productInputType = new InputObjectType([
                'name' => 'ProductInput',
                'fields' => [
                    'id' => [
                        'type' => Type::string(),
                    ],
                    'name' => [
                        'type' => Type::string(),
                    ],
                    'inStock' => [
                        'type' => Type::boolean(),
                    ],
                    'description' => [
                        'type' => Type::string(),
                    ],
                    'brand' => [
                        'type' => Type::string(),
                    ],
                    'category' => [
                        'type' => Type::string(),
                    ],
                    'gallery' => [
                        'type' => Type::listOf(Type::string()),
                    ],
                    'prices' => [
                        'type' => Type::listOf($priceInputType),
                    ],
                    'attributes' => [
                        'type' => Type::listOf($attributeSetInputType),
                    ],
                ],
            ]);


            $queryType = new ObjectType([
                'name' => 'Query',
                'fields' => [
                    'echo' => [
                        'type' => Type::string(),
                        'args' => [
                            'message' => ['type' => Type::string()],
                        ],
                        'resolve' => static fn($rootValue, array $args): string => $rootValue['prefix'] . $args['message'],
                    ],
                    'hello' => [
                        'type' => $testType,
                        'resolve' => static fn($rootValue, array $args) => $rootValue,
                    ],
                    'products' => [
                        'type' => Type::listOf($productType),
                        'resolve' => function () {
                            return Product::getAll();
                        },
                    ],
                    'categories' => [
                        'type' => Type::listOf($categoryType),
                        'resolve' => function () {
                            return Category::getAll();
                        },
                    ],
                    'category' => [
                        'type' => $categoryType,
                        'args' => [
                            'id' => ['type' => Type::int()],
                            'name' => ['type' => Type::string()],
                        ],
                        'resolve' => function ($rootValue, array $args) {
                            if (isset($args['id']) && isset($args['name'])) {
                                throw new Error('You must provide either an id or name');
                            } elseif (!empty($args['id'])) {
                                $answer = Category::getById($args['id']);
                                return $answer ? $answer : throw new Error('Category not found');
                            } elseif (!empty($args['name'])) {
                                $answer = Category::getByName($args['name']);
                                return $answer ? $answer : throw new Error('Category not found');

                            } else {
                                throw new Error('You must provide either an id or name');
                            }

                        },
                    ],
                ],
            ]);



            $mutationType = new ObjectType([
                'name' => 'Mutation',
                'fields' => [
                    'sum' => [
                        'type' => Type::int(),
                        'args' => [
                            'x' => ['type' => Type::int()],
                            'y' => ['type' => Type::int()],
                        ],
                        'resolve' => static fn($calc, array $args): int => $args['x'] + $args['y'],
                    ],
                    'createCategory' => [
                        'type' => Type::id(),
                        'args' => [
                            'name' => ['type' => Type::string()],
                        ],
                        'resolve' => function ($rootValue, array $args) {
                            try {
                                return Category::create(
                                    [
                                        'name' => $args['name'],
                                    ]
                                );
                            } catch (Throwable $e) {
                                return $e->getMessage();
                            }
                        },
                    ],
                    'deleteCategory' => [
                        'type' => Type::int(),
                        'args' => [
                            'id' => ['type' => Type::int()],
                            'name' => ['type' => Type::string()],
                        ],
                        'resolve' => function ($rootValue, array $args) {
                            if (isset($args['id']) && isset($args['name'])) {
                                throw new Error('You must provide either an id or name');
                            } elseif (!empty($args['id'])) {
                                $answer = Category::delete($args['id']);
                                return $answer ? $answer : throw new Error('Category not found');
                            } elseif (!empty($args['name'])) {
                                $answer = Category::deleteByName($args['name']);
                                return $answer ? $answer : throw new Error('Category not found');
                            } else {
                                throw new Error('You must provide either an id or name');
                            }
                        },
                    ],
                    'updateCategory' => [
                        'type' => Type::int(),
                        'args' => [
                            'id' => ['type' => Type::int()],
                            'name' => ['type' => Type::string()],
                        ],
                        'resolve' => function ($rootValue, array $args) {
                            if (isset($args['id'])) {
                                error_log($args['id']);
                                $answer = Category::update($args['id'], ['name' => $args['name']]);
                                return $answer ? $answer : throw new Error('Category not found');
                            } else {
                                throw new Error('You must provide an id to update');
                            }
                        },
                    ],
                    'createProduct' => [
                        'type' => Type::id(),
                        'args' => [
                            'input' => ['type' => $productInputType],
                        ],
                        'resolve' => function ($rootValue, array $args) {
                            try {
                                error_log("-----------------");
                                error_log(print_r($args['input'], true));
                                return Product::create($args['input']);
                            } catch (Throwable $e) {
                                return $e->getMessage();
                            }
                        },
                    ],
                ],
            ]);

            // See docs on schema options:
            // https://webonyx.github.io/graphql-php/schema-definition/#configuration-options
            $schema = new Schema(
                (new SchemaConfig())
                    ->setQuery($queryType)
                    ->setMutation($mutationType)
            );

            $rawInput = file_get_contents('php://input');
            if ($rawInput === false) {
                throw new RuntimeException('Failed to get php://input');
            }


            $input = json_decode($rawInput, true);
            $query = $input['query'];
            $variableValues = $input['variables'] ?? null;




            $rootValue = ['prefix' => 'You said: '];
            $result = GraphQLBase::executeQuery($schema, $query, $rootValue, null, $variableValues);
            $output = $result->toArray();


        } catch (Throwable $e) {
            error_log($e->getMessage());
            $output = [
                'error' => [
                    'message' => $e->getMessage(),
                ],
            ];
        }

        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($output);
    }
}