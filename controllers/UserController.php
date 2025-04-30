<?php
class UserController extends BaseController {
    private $userModel;

    public function __construct($pdo) {
        parent::__construct($pdo);
        $this->userModel = $this->loadModel('User');
    }

    public function index() {
        $users = $this->userModel->getAll();
        $this->view('user/index', ['title' => 'Users', 'users' => $users]);
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($email) || empty($password)) {
                $this->setSnackbar('All fields are required', 'error');
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->setSnackbar('Invalid email format', 'error');
            } else {
                $data = [
                    'username' => $username,
                    'email' => $email,
                    'password' => $password
                ];
                if ($this->userModel->create($data)) {
                    $this->setSnackbar('User added successfully!', 'success');
                    $this->redirect('user');
                } else {
                    $this->setSnackbar('Unable to add user.', 'error');
                }
            }
        }
    }

    public function editUsername($id) {
        $user = $this->userModel->getById($id);
        if (!$user) {
            $this->setSnackbar('User not found', 'error');
            $this->redirect('user');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            if (empty($username)) {
                $this->setSnackbar('Username is required', 'error');
            } else {
                if ($this->userModel->update($id, ['username' => $username])) {
                    if ($id == $_SESSION['user_id']) {
                        $_SESSION['username'] = $username;
                    }
                    $this->setSnackbar('Username updated successfully!', 'success');
                    $this->redirect('user');
                } else {
                    $this->setSnackbar('Unable to update username.', 'error');
                }
            }
        }
    }

    public function editEmail($id) {
        $user = $this->userModel->getById($id);
        if (!$user) {
            $this->setSnackbar('User not found', 'error');
            $this->redirect('user');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            if (empty($email)) {
                $this->setSnackbar('Email is required', 'error');
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->setSnackbar('Invalid email format', 'error');
            } else {
                if ($this->userModel->update($id, ['email' => $email])) {
                    $this->setSnackbar('Email updated successfully!', 'success');
                    $this->redirect('user');
                } else {
                    $this->setSnackbar('Unable to update email.', 'error');
                }
            }
        }
    }

    public function delete($id) {
        $user = $this->userModel->getById($id);
        if (!$user) {
            $this->setSnackbar('User not found', 'error');
            $this->redirect('user');
        }
        if ($this->userModel->delete($id)) {
            if ($id == $_SESSION['user_id']) {
                $this->setSnackbar('Unable to delete admin account', 'error');
            } else {
                $this->setSnackbar('User deleted successfully!', 'success');
            }
        } else {
            $this->setSnackbar('Unable to delete user.', 'error');
        }
        $this->redirect('user');
    }
}