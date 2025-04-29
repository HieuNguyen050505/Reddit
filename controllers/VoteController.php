<?php
class VoteController extends BaseController {
    private $voteModel;

    public function __construct($pdo) {
        parent::__construct($pdo);
        $this->voteModel = $this->loadModel('Vote');
    }

    public function index() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'error' => 'Invalid request method']);
            exit;
        }

        $post_id = (int)$_POST['post_id'];
        $vote_type = $_POST['vote_type'];
        $user_id = $_SESSION['user_id'];
        $remove_vote = isset($_POST['remove_vote']) && $_POST['remove_vote'] === 'true';

        $this->pdo->beginTransaction();
        $existing_vote = $this->voteModel->getVoteStatus($post_id, $user_id);

        if ($remove_vote && $existing_vote) {
            $this->voteModel->removeVote($post_id, $user_id);
        } elseif ($existing_vote) {
            if ($existing_vote !== $vote_type) {
                $this->voteModel->updateVote($post_id, $user_id, $vote_type);
            }
        } else {
            $this->voteModel->addVote($post_id, $user_id, $vote_type);
        }

        $vote_count = $this->voteModel->getVoteCount($post_id);
        $this->pdo->commit();

        echo json_encode(['success' => true, 'new_count' => $vote_count]);
        exit;
    }

    public function status($post_id) {
        // Check if user is logged in before accessing session variable
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
        $vote_type = $this->voteModel->getVoteStatus($post_id, $user_id);
        echo json_encode(['user_vote' => $vote_type]);
        exit;
    }
}
?>