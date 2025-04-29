<?php
require_once 'Middleware.php';

class Auth extends Middleware {
    public function handle() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirectWithMessage('/reddit/login', 'Please log in to access this page', 'warning');
        }
        return true;
    }
}