<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Debugging output
error_log("Accessed index.php");

// Setup FastRoute dispatcher
$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('POST', '/graphql', [App\Controller\GraphQL::class, 'handle']);
    $r->addRoute('GET', '/', function() {
        echo 'Welcome to the Home Page!';
    });
});

// Debugging output
error_log("Dispatcher created");

// Dispatch the request
$routeInfo = $dispatcher->dispatch(
    $_SERVER['REQUEST_METHOD'],
    $_SERVER['REQUEST_URI']
);

// Debugging output
error_log("Dispatching request");

// Handle the route
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        http_response_code(404);
        echo '404 Not Found';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        http_response_code(405);
        echo '405 Method Not Allowed';
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        call_user_func_array($handler, $vars);
        break;
}


