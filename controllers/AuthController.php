<?php
class AuthController extends BaseController {
    private $userModel;

    public function __construct($pdo) {
        parent::__construct($pdo);
        $this->userModel = new User($pdo);
    }

    public function login() {
        if ($this->isLoggedIn()) {
            $this->redirect('');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->setSnackbar('Invalid email format', 'error');
            } else {
                $user = $this->userModel->findByEmail($email);
                if ($user && password_verify($password, $user['password'])) {
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
            $password = $_POST['password'];

            $errors = [];
            if (strlen($username) < 3) {
                $errors[] = 'Username must be at least 3 characters';
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Invalid email format';
            }
            if (strlen($password) < 6) {
                $errors[] = 'Password must be at least 6 characters';
            }

            if ($errors) {
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
                        $_SESSION['user_id'] = $this->pdo->lastInsertId();
                        $_SESSION['is_admin'] = 0;
                        $_SESSION['avatar_path'] = $data['avatar_path'];
                        $_SESSION['username'] = $username;

                        setcookie('user_id', $_SESSION['user_id'], [
                            'expires' => time() + 3600,
                            'path' => '/',
                            'secure' => true,
                            'httponly' => true,
                            'samesite' => 'Strict'
                        ]);

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
}