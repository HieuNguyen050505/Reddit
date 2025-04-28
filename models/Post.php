<?php
// models/Post.php
class Post {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($data) {
        $stmt = $this->pdo->prepare("INSERT INTO posts (title, content, image_path, user_id, module_id) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$data['title'], $data['content'], $data['image_path'], $data['user_id'], $data['module_id']]);
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT p.*, u.username, u.avatar_path, m.module_name,
            (SELECT COUNT(*) FROM votes WHERE post_id = p.post_id AND vote_type = 'up') as upvotes,
            (SELECT COUNT(*) FROM votes WHERE post_id = p.post_id AND vote_type = 'down') as downvotes
            FROM posts p
            JOIN users u ON p.user_id = u.user_id
            JOIN modules m ON p.module_id = m.module_id
            WHERE post_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAll($module_id = null) {
        $query = "SELECT p.*, u.username, u.avatar_path, m.module_name,
            (SELECT COUNT(*) FROM votes WHERE post_id = p.post_id AND vote_type = 'up') as upvotes,
            (SELECT COUNT(*) FROM votes WHERE post_id = p.post_id AND vote_type = 'down') as downvotes
            FROM posts p
            JOIN users u ON p.user_id = u.user_id
            JOIN modules m ON p.module_id = m.module_id";
        if ($module_id) {
            $query .= " WHERE p.module_id = ? ORDER BY p.created_at DESC";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$module_id]);
        } else {
            $query .= " ORDER BY p.created_at DESC";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $stmt = $this->pdo->prepare("UPDATE posts SET title = ?, content = ?, image_path = ?, module_id = ? WHERE post_id = ?");
        return $stmt->execute([$data['title'], $data['content'], $data['image_path'], $data['module_id'], $id]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM posts WHERE post_id = ?");
        return $stmt->execute([$id]);
    }
}