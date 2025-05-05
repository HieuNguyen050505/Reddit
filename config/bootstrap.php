<?php
// Set default timezone to UTC
date_default_timezone_set('UTC');

session_start();
require_once 'vendor/autoload.php';
require_once 'database.php';
require_once 'cloudinary.php';

function render404Page() {
    http_response_code(404);
    include __DIR__ . '/../views/errors/404.php';
    exit();
}

$routes = require_once 'routes.php';

// Process the request and load the appropriate controller
function processRequest($pdo, $routes) {
    // Get the URL path and remove the base directory ('reddit')
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = trim($uri, '/');
    if (strpos($uri, 'reddit') === 0) {
        $uri = substr($uri, strlen('reddit'));
    }
    $uri = trim($uri, '/');

    $controller = null;
    $action = null;
    $method_params = [];
    $middlewareClasses = [];

    // Match the URI against defined routes
    foreach ($routes as $pattern => $route) {
        $pattern = str_replace('/', '\/', $pattern);
        $pattern = ltrim($pattern, '\/');
        $pattern = $pattern . '\/?';
        if (preg_match("/^$pattern$/i", $uri, $matches)) {
            $controller = $route['controller'] ?? null;
            $action = $route['action'] ?? null;
            $middlewareClasses = $route['middleware'] ?? [];

            if (!empty($route['params'])) {
                foreach ($route['params'] as $position => $match_index) {
                    if ($match_index === null) {
                        $method_params[$position] = null;
                    } elseif (isset($matches[$match_index])) {
                        $method_params[$position] = $matches[$match_index];
                    }
                }
                ksort($method_params);
            }
            break;
        }
    }

    if (!$controller || !$action) {
        render404Page();
    }

    // Apply middleware
    foreach ($middlewareClasses as $middlewareClass) {
        require_once __DIR__ . "/../middleware/{$middlewareClass}.php";
        $middleware = new $middlewareClass();
        $middleware->handle();
        $middleware->checkSessionTimeout($pdo);
    }

    // Load the controller
    $controllerFile = __DIR__ . "/../controllers/{$controller}.php";
    if (file_exists($controllerFile)) {
        require_once $controllerFile;
        $controllerInstance = new $controller($pdo);
        if (method_exists($controllerInstance, $action)) {
            call_user_func_array([$controllerInstance, $action], $method_params);
        } else {
            render404Page();
        }
    } else {
        render404Page();
    }
}

// Process the request
processRequest($pdo, $routes);