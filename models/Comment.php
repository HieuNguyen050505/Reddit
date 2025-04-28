<?php
class Comment {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getByPostId($post_id) {
        $stmt = $this->pdo->prepare("SELECT c.*, u.username, u.avatar_path FROM comments c
            JOIN users u ON c.user_id = u.user_id WHERE c.post_id = ? ORDER BY c.created_at ASC");
        $stmt->execute([$post_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add($data) {
        $stmt = $this->pdo->prepare("INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)");
        return $stmt->execute([$data['post_id'], $data['user_id'], $data['content']]);
    }

    public function update($id, $content) {
        $stmt = $this->pdo->prepare("UPDATE comments SET content = ? WHERE comment_id = ?");
        return $stmt->execute([$content, $id]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM comments WHERE comment_id = ?");
        return $stmt->execute([$id]);
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM comments WHERE comment_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>