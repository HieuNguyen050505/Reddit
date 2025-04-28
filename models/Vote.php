<?php
class Vote {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getVoteStatus($post_id, $user_id) {
        $stmt = $this->pdo->prepare("SELECT vote_type FROM votes WHERE post_id = ? AND user_id = ?");
        $stmt->execute([$post_id, $user_id]);
        $vote = $stmt->fetch(PDO::FETCH_ASSOC);
        return $vote ? $vote['vote_type'] : null;
    }

    public function addVote($post_id, $user_id, $vote_type) {
        $stmt = $this->pdo->prepare("INSERT INTO votes (post_id, user_id, vote_type) VALUES (?, ?, ?)");
        return $stmt->execute([$post_id, $user_id, $vote_type]);
    }

    public function updateVote($post_id, $user_id, $vote_type) {
        $stmt = $this->pdo->prepare("UPDATE votes SET vote_type = ? WHERE post_id = ? AND user_id = ?");
        return $stmt->execute([$vote_type, $post_id, $user_id]);
    }

    public function removeVote($post_id, $user_id) {
        $stmt = $this->pdo->prepare("DELETE FROM votes WHERE post_id = ? AND user_id = ?");
        return $stmt->execute([$post_id, $user_id]);
    }

    public function getVoteCount($post_id) {
        $stmt = $this->pdo->prepare("SELECT 
            (SELECT COUNT(*) FROM votes WHERE post_id = ? AND vote_type = 'up') -
            (SELECT COUNT(*) FROM votes WHERE post_id = ? AND vote_type = 'down') AS vote_count");
        $stmt->execute([$post_id, $post_id]);
        return $stmt->fetchColumn();
    }
}
?>