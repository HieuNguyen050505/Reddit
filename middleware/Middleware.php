<?php
abstract class Middleware {
    abstract public function handle();
    
    protected function redirectWithMessage($url, $message, $type = 'error') {
        $_SESSION['snackbar_message'] = $message;
        $_SESSION['snackbar_type'] = $type;
        header("Location: $url");
        exit();
    }
}