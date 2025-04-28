<?php
class ContactController extends BaseController {
    private $userModel;

    public function __construct($pdo) {
        parent::__construct($pdo);
        $this->userModel = new User($pdo);
    }

    public function index() {
        if (!$this->isLoggedIn() || $this->isAdmin()) {
            $this->redirect('login');
        }

        $name = '';
        $email = '';
        $message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $message = trim($_POST['message'] ?? '');

            if (strlen($name) < 2) {
                $this->setSnackbar('Name must be at least 2 characters long', 'error');
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->setSnackbar('Please enter a valid email address', 'error');
            } elseif (strlen($message) < 10) {
                $this->setSnackbar('Message must be at least 10 characters long', 'error');
            } else {
                $adminEmail = $this->userModel->getAdminEmail();
                if (!$adminEmail) {
                    $this->setSnackbar('No admin email found. Please contact support.', 'error');
                } else {
                    try {
                        $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
                        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
                        $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

                        $htmlBody = "<h2>Student Question</h2><p><strong>Name:</strong> {$name}</p><p><strong>Email:</strong> {$email}</p><p><strong>Message:</strong></p><p>{$message}</p>";
                        $altBody = "Student Question\n\nName: {$name}\nEmail: {$email}\nMessage:\n{$message}";

                        $this->configureMailer(
                            'noreply@yourdomain.com',
                            $name,
                            $adminEmail,
                            'Student Question',
                            $htmlBody,
                            $altBody,
                            $email,
                            $name
                        );

                        $this->setSnackbar('Message sent successfully!', 'success');
                        $name = $email = $message = '';
                    } catch (Exception $e) {
                        $this->setSnackbar('Failed to send message: ' . $e->getMessage(), 'error');
                    }
                }
            }
        }

        $this->view('contact/index', ['title' => 'Contact Admin', 'name' => $name, 'email' => $email, 'message' => $message]);
    }
}