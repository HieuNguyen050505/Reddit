<?php
class BaseController {
    protected $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    protected function view($view, $data = []) {
        extract($data);
        ob_start();
        require "views/$view.php";
        $content = ob_get_clean();
        require "views/layout/main.php";
    }

    protected function redirect($url) {
        $redirectUrl = '/reddit/' . $url;
        header("Location: $redirectUrl");
        exit;
    }

    protected function isAdmin() {
        return isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
    }

    protected function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    protected function setSnackbar($message, $type) {
        $_SESSION['snackbar_message'] = $message;
        $_SESSION['snackbar_type'] = $type;
    }
}