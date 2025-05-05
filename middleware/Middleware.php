<?php
abstract class Middleware {
    abstract public function handle();
    
    protected function redirectWithMessage($url, $message, $type = 'error') {
        $_SESSION['snackbar_message'] = $message;
        $_SESSION['snackbar_type'] = $type;
        header("Location: $url");
        exit();
    }

    // Check session timeout
    public function checkSessionTimeout($pdo) {
        if (isset($_SESSION['user_id'])) {
            if (!isset($_COOKIE['user_id'])) {
                require_once __DIR__ . '/../controllers/AuthController.php';
                $authController = new AuthController($pdo);
                $authController->logout();
                exit();
            }
        }
    }
}