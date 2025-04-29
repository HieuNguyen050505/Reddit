<?php
require_once 'Middleware.php';

class Guest extends Middleware {
    public function handle() {
        // Get the current URI
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = trim($uri, '/');
        
        // Check if this is login or signup page
        $isAuthPage = false;
        if (strpos($uri, 'reddit/login') !== false || strpos($uri, 'reddit/signup') !== false) {
            $isAuthPage = true;
        }
        
        // Only redirect if user is logged in AND trying to access login/signup pages
        if (isset($_SESSION['user_id']) && $isAuthPage) {
            $this->redirectWithMessage('/reddit/', 'You have already logged in', 'info');
        }
        
        return true;
    }
}