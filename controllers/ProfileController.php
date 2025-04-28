<?php
class ProfileController extends BaseController {
    private $userModel;

    public function __construct($pdo) {
        parent::__construct($pdo);
        $this->userModel = new User($pdo);
    }

    public function index() {
        $user_id = $_SESSION['user_id'];
        $user = $this->userModel->getById($user_id);
        if (!$user) {
            $this->setSnackbar('User data not found', 'error');
            $this->redirect('login');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action']) && $_POST['action'] === 'change_password') {
                $this->handlePasswordChange($user_id, $user['password']);
            } else {
                $this->handleProfileUpdate($user_id, $user);
            }
            $this->redirect('profile');
        }

        $this->view('profile/edit', [
            'title' => 'Edit Profile',
            'user' => $user
        ]);
    }

    private function handlePasswordChange($user_id, $current_password) {
        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        $errors = $this->validatePasswordChange($old_password, $new_password, $confirm_password, $current_password);
        if ($errors) {
            $this->setSnackbar(implode('; ', $errors), 'error');
            return;
        }

        if ($this->userModel->updatePassword($user_id, $new_password)) {
            $this->setSnackbar('Password changed successfully!', 'success');
        } else {
            $this->setSnackbar('Unable to change password.', 'error');
        }
    }

    private function validatePasswordChange($old_password, $new_password, $confirm_password, $current_password) {
        $errors = [];
        if (!password_verify($old_password, $current_password)) {
            $errors[] = 'Incorrect old password';
        }
        if (strlen($new_password) < 8) {
            $errors[] = 'New password must be at least 8 characters';
        }
        if ($new_password !== $confirm_password) {
            $errors[] = 'New passwords do not match';
        }
        return $errors;
    }

    private function handleProfileUpdate($user_id, $user) {
        $username = trim($_POST['username']);
        $bio = trim($_POST['bio']);
        $email = trim($_POST['email']);
        $avatar_path = $user['avatar_path'];

        $errors = $this->validateProfileUpdate($username, $email, $user_id, $user['email']);
        if ($errors) {
            $this->setSnackbar(implode('; ', $errors), 'error');
            return;
        }

        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
            $avatar_path = $this->uploadImage('avatar', 'studentq/avatars', $user_id . '_' . time());
            if (!$avatar_path) {
                $this->setSnackbar('Failed to upload avatar.', 'error');
                return;
            }
        }

        $data = [
            'username' => $username,
            'bio' => $bio,
            'email' => $email ?: $user['email'],
            'avatar_path' => $avatar_path
        ];

        if ($this->userModel->update($user_id, $data)) {
            $_SESSION['avatar_path'] = $avatar_path;
            $_SESSION['username'] = $username;
            $this->setSnackbar('Profile updated successfully!', 'success');
        } else {
            $this->setSnackbar('Unable to update profile.', 'error');
        }
    }

    private function validateProfileUpdate($username, $email, $user_id, $current_email) {
        $errors = [];
        if (strlen($username) < 3) {
            $errors[] = 'Username must be at least 3 characters';
        }
        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format';
        }
        if (!empty($email) && $email !== $current_email && $this->userModel->emailExists($email, $user_id)) {
            $errors[] = 'Email is already in use';
        }
        return $errors;
    }
}
?>