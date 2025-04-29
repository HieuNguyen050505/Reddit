<?php
class AuthController extends BaseController {
    private $userModel;

    public function __construct($pdo) {
        parent::__construct($pdo);
        $this->userModel = $this->loadModel('User');
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';

            if (!$this->validateEmail($email)) {
                $this->setSnackbar('Invalid email format', 'error');
            } else {
                $user = $this->userModel->findByEmail($email);
                if ($user && password_verify($password, $user['password'])) {
                    $this->createUserSession($user);
                    $this->setSnackbar('Login successful!', 'success');
                    $this->redirect('');
                } else {
                    $this->setSnackbar('Invalid email or password', 'error');
                }
            }
        }

        $this->view('auth/login', ['title' => 'Login']);
    }

    public function signup() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));
            $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
            $password = $_POST['password'] ?? '';

            $errors = $this->validateSignupData($username, $email, $password);
            
            if (!empty($errors)) {
                $this->setSnackbar(implode('; ', $errors), 'error');
            } else {
                if ($this->userModel->emailExists($email)) {
                    $this->setSnackbar('Email is already in use', 'error');
                } elseif ($this->userModel->usernameExists($username)) {
                    $this->setSnackbar('Username is already taken', 'error');
                } else {
                    $data = [
                        'username' => $username,
                        'email' => $email,
                        'password' => $password,
                        'avatar_path' => 'https://res.cloudinary.com/dwczo5jpk/image/upload/v1741024126/studentq/avatars/2_1741024123.png'
                    ];
                    
                    if ($this->userModel->create($data)) {
                        $userId = $this->pdo->lastInsertId();
                        $user = [
                            'user_id' => $userId,
                            'is_admin' => 0,
                            'avatar_path' => $data['avatar_path'],
                            'username' => $username
                        ];
                        
                        $this->createUserSession($user);
                        $this->setSnackbar('Account created successfully!', 'success');
                        $this->redirect('');
                    } else {
                        $this->setSnackbar('Unable to sign up. Please try again later.', 'error');
                    }
                }
            }
        }

        $this->view('auth/signup', ['title' => 'Sign Up']);
    }

    public function logout() {
        setcookie('user_id', '', time() - 3600, '/');
        session_destroy();
        $this->redirect('');
    }
    
    private function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
    
    private function validateSignupData($username, $email, $password) {
        $errors = [];
        
        if (strlen($username) < 3) {
            $errors[] = 'Username must be at least 3 characters';
        }
        
        if (!$this->validateEmail($email)) {
            $errors[] = 'Invalid email format';
        }
        
        if (strlen($password) < 6) {
            $errors[] = 'Password must be at least 6 characters';
        }
        
        return $errors;
    }
    
    private function createUserSession($user) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['is_admin'] = $user['is_admin'];
        $_SESSION['avatar_path'] = $user['avatar_path'];
        $_SESSION['username'] = $user['username'];

        setcookie('user_id', $user['user_id'], [
            'expires' => time() + 3600,
            'path' => '/',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Strict'
        ]);
    }
}