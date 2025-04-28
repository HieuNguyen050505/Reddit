<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

class ContactController extends BaseController {
    private $userModel;
    private $mailer;

    public function __construct($pdo) {
        parent::__construct($pdo);
        $this->userModel = new User($pdo);

        // Load environment variables
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        // Initialize PHPMailer
        $this->mailer = new PHPMailer(true);
    }

    private function configureMailer($fromEmail, $fromName, $toEmail, $subject, $htmlBody, $altBody, $replyToEmail = null, $replyToName = null) {
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
            $this->setSnackbar("Failed to send email" , "error");
        }
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