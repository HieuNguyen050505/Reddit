<?php
require_once 'Middleware.php';

class Student extends Middleware {
    public function handle() {
        if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) {
            $this->redirectWithMessage('/reddit/', 'Only user is allowed to access this page', 'info');
        }
        return true;
    }
}