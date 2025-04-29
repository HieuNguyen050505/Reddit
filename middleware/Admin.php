<?php
require_once 'Middleware.php';

class Admin extends Middleware {
    public function handle() {
        if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
            $this->redirectWithMessage('/reddit/', 'You do not have permission to access this page', 'error');
        }
        return true;
    }
}