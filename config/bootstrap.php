<?php
// Set default timezone to UTC
date_default_timezone_set('UTC');

// Start session
session_start();
require_once 'vendor/autoload.php';

// Load database connection
require_once 'database.php';
require_once 'cloudinary.php';

// Check session timeout
function checkSessionTimeout($pdo) {
    if (isset($_SESSION['user_id'])) {
        // Check if user_id cookie exists
        if (!isset($_COOKIE['user_id'])) {
            // Cookie has expired, log the user out
            require_once __DIR__ . '/../controllers/AuthController.php';
            $authController = new AuthController($pdo);
            $authController->logout();
            exit();
        }
    }
}

// Function to render 404 page
function render404Page() {
    http_response_code(404);
    include __DIR__ . '/../views/errors/404.php';
    exit();
}

// Run session timeout check
checkSessionTimeout($pdo);

// Load routes
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

    // Default values
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