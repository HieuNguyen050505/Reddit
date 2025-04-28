<?php
// models/User.php
class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $password_hash = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("
            INSERT INTO users (username, email, password, is_admin, avatar_path) 
            VALUES (?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['username'],
            $data['email'],
            $password_hash,
            $data['is_admin'] ?? 0,
            $data['avatar_path'] ?? 'https://res.cloudinary.com/dwczo5jpk/image/upload/v1741024126/studentq/avatars/2_1741024123.png'
        ]);
    }

    public function delete($user_id) {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE user_id = ?");
        return $stmt->execute([$user_id]);
    }

    public function emailExists($email, $excludeUserId = null) {
        $query = "SELECT COUNT(*) FROM users WHERE email = ?";
        $params = [$email];
        if ($excludeUserId) {
            $query .= " AND user_id != ?";
            $params[] = $excludeUserId;
        }
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

    public function usernameExists($username, $excludeUserId = null) {
        $query = "SELECT COUNT(*) FROM users WHERE username = ?";
        $params = [$username];
        if ($excludeUserId) {
            $query .= " AND user_id != ?";
            $params[] = $excludeUserId;
        }
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePassword($id, $password) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("UPDATE users SET password = ? WHERE user_id = ?");
        return $stmt->execute([$password, $id]);
    }

    public function update($id, $data) {
        $fields = [];
        $params = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = ?";
            $params[] = $value;
        }
        $params[] = $id;
        $query = "UPDATE users SET " . implode(', ', $fields) . " WHERE user_id = ?";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute($params);
    }

    public function getAdminEmail() {
        $stmt = $this->pdo->prepare("SELECT email FROM users WHERE is_admin = ? LIMIT 1");
        $stmt->execute([1]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['email'] : null;
    }
}