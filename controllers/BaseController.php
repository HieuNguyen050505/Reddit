<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;
use \Cloudinary\Api\Upload\UploadApi;

class BaseController {
    protected $pdo;
    protected $mailer;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        
        // Load environment variables
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
        
        // Initialize PHPMailer
        $this->mailer = new PHPMailer(true);
    }

    protected function loadModel($modelName) {
        // Path to the model file
        $modelFile = __DIR__ . "/../models/{$modelName}.php";
        
        // Check if file exists and include it
        if (file_exists($modelFile)) {
            require_once $modelFile;
            
            // Create and return a new instance of the model
            if (class_exists($modelName)) {
                return new $modelName($this->pdo);
            }
        }
        
        return null;
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

    public function setSnackbar($message, $type) {
        $_SESSION['snackbar_message'] = $message;
        $_SESSION['snackbar_type'] = $type;
    }
    
    protected function uploadImage($file_key, $folder) {
        try {
            if (!isset($_FILES[$file_key]) || $_FILES[$file_key]['error'] != 0) {
                return null;
            }
            $upload = new UploadApi();
            $options = [
                'folder' => $folder,
                'public_id' => time() . '_' . basename($_FILES['image']['name'])
            ];
            $result = $upload->upload($_FILES[$file_key]['tmp_name'], $options);
            return $result['secure_url'];
        } catch (\Exception $e) {
            return null;
        }
    }
    
    protected function configureMailer($fromEmail, $fromName, $toEmail, $subject, $htmlBody, $altBody, $replyToEmail = null, $replyToName = null) {
        try {
            // SMTP configuration from .env
            $this->mailer->isSMTP();
            $this->mailer->Host = $_ENV['SMTP_HOST'];
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = $_ENV['SMTP_USERNAME'];
            $this->mailer->Password = $_ENV['SMTP_PASSWORD'];
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mailer->Port = $_ENV['SMTP_PORT'];

            // Clear previous recipients
            $this->mailer->clearAddresses();
            $this->mailer->clearReplyTos();

            // Set email details
            $this->mailer->setFrom($fromEmail, $fromName);
            $this->mailer->addAddress($toEmail);
            if ($replyToEmail) {
                $this->mailer->addReplyTo($replyToEmail, $replyToName ?: $fromName);
            }

            $this->mailer->isHTML(true);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $htmlBody;
            $this->mailer->AltBody = $altBody;

            // Send the email
            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log("PHPMailer configuration failed: " . $e->getMessage());
            http_response_code(500);
            exit('Internal Server Error: Unable to configure PHPMailer');
        }
    }
}