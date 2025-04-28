<?php
class CommentController extends BaseController {
    private $commentModel;

    public function __construct($pdo) {
        parent::__construct($pdo);
        $this->commentModel = new Comment($pdo);
    }

    public function add() {
        if (!$this->isLoggedIn()) $this->redirect('login');

        $post_id = (int)$_POST['post_id'];
        $content = trim($_POST['content']);
        $user_id = $_SESSION['user_id'];

        if ($this->commentModel->add(['post_id' => $post_id, 'user_id' => $user_id, 'content' => $content])) {
            $this->redirect("post/$post_id");
        } else {
            $this->setSnackbar('Unable to add comment.', 'error');
            $this->redirect("post/$post_id");
        }
    }

    public function edit() {
        if (!$this->isLoggedIn()) $this->redirect('login');
    
        $id = $_POST['comment_id']; // Get comment_id from form
        $comment = $this->commentModel->getById($id);
        if (!$comment || ($comment['user_id'] != $_SESSION['user_id'] && !$this->isAdmin())) {
            $this->setSnackbar('Comment not found or you are not authorized to edit it', 'error');
            $this->redirect('');
        }
    
        $content = trim($_POST['content']);
        if ($this->commentModel->update($id, $content)) {
            $this->setSnackbar('Comment updated successfully', 'success');
            $this->redirect("post/{$comment['post_id']}");
        } else {
            $this->setSnackbar('Unable to update comment.', 'error');
            $this->redirect("post/{$comment['post_id']}");
        }
    }

    public function delete($id) {
        if (!$this->isLoggedIn()) $this->redirect('login');

        $comment = $this->commentModel->getById($id);
        if (!$comment || ($comment['user_id'] != $_SESSION['user_id'] && !$this->isAdmin())) {
            $this->setSnackbar('Comment not found or you are not authorized to delete it', 'error');
            $this->redirect('');
        }

        if ($this->commentModel->delete($id)) {
            $this->redirect("post/{$comment['post_id']}");
        } else {
            $this->setSnackbar('Unable to delete comment.', 'error');
            $this->redirect("post/{$comment['post_id']}");
        }
    }
}
?>