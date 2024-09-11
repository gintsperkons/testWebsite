<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/../vendor/autoload.php';

// Setup FastRoute dispatcher
$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('POST', '/graphql', [App\Controller\GraphQL::class, 'handle']);
    $r->addRoute('GET', '/', function() {
        echo file_get_contents(__DIR__ . '/../public/index.html');
    });
});

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Dispatch the request
$routeInfo = $dispatcher->dispatch(
    $_SERVER['REQUEST_METHOD'],
    $_SERVER['REQUEST_URI']
);



// Serve static files directly
if (preg_match('/\.(jpg|jpeg|png|gif|css|js|jsx)$/', $_SERVER['REQUEST_URI'])) {
    $filePath = __DIR__ . '/../public' . $_SERVER['REQUEST_URI'];
    if (file_exists($filePath) && is_file($filePath)) {
        if (str_ends_with($filePath, '.css')) {
            $mimeType = 'text/css';
        } else if (str_ends_with($filePath, '.js')) {
            $mimeType = 'application/javascript';
        } else {
            $mimeType = mime_content_type($filePath);
        }
        header('Content-Type: ' . $mimeType);
        readfile($filePath);
        exit;
    } else {
        http_response_code(404);
        echo '404 Not Found';
        exit;
    }
}

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
