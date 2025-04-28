<?php
session_start();
require_once 'vendor/autoload.php';
require_once 'config/database.php';
require_once 'config/cloudinary.php';

// Check if user is logged in via session but missing user_id cookie
if (isset($_SESSION['user_id']) && !isset($_COOKIE['user_id'])) {
    require_once 'controllers/AuthController.php';
    $authController = new AuthController($pdo);
    $authController->logout();
    exit();
}

// Function to render 404 page
function render404Page() {
    http_response_code(404);
    include 'views/errors/404.php';
    exit();
}

// Load routes
$routes = require_once 'config/routes.php';

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

// Match the URI against defined routes
foreach ($routes as $pattern => $route) {
    $pattern = str_replace('/', '\/', $pattern);
    $pattern = ltrim($pattern, '\/');
    $pattern = $pattern . '\/?';
    if (preg_match("/^$pattern$/i", $uri, $matches)) {
        $controller = $route['controller'] ?? null;
        $action = $route['action'] ?? null;

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

// Load the controller
$controllerFile = 'controllers/' . $controller . '.php';
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