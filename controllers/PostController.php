<?php
class PostController extends BaseController {
    private $postModel;
    private $moduleModel;
    private $commentModel;

    public function __construct($pdo) {
        parent::__construct($pdo);
        $this->postModel = new Post($pdo);
        $this->moduleModel = new Module($pdo);
        $this->commentModel = new Comment($pdo);
    }

    public function create() {
        if (!$this->isLoggedIn()) {
            $this->setSnackbar('Please log in to add a post', 'error');
            $this->redirect('login');
        }

        $modules = $this->moduleModel->getAll();
        if (empty($modules)) {
            $this->setSnackbar('No modules available to post in', 'info');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $content = $_POST['content'] ?? '';
            $module_id = $_POST['module_id'] ?? '';
            $image_path = null;

            if (empty($title)) {
                $this->setSnackbar('Post title is required', 'error');
            } elseif (strlen($title) > 300) {
                $this->setSnackbar('Post title must be 300 characters or less', 'error');
            } elseif (empty($module_id) || !$this->moduleModel->findById($module_id)) {
                $this->setSnackbar('Please select a valid module', 'error');
            } else {
                if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                    $image_path = $this->uploadImage('image', 'studentq/posts');
                    if (!$image_path) {
                        $this->setSnackbar('Failed to upload image.', 'error');
                        return;
                    }
                }
                $data = [
                    'title' => $title,
                    'content' => $content,
                    'image_path' => $image_path,
                    'user_id' => $_SESSION['user_id'],
                    'module_id' => $module_id
                ];
                if ($this->postModel->create($data)) {
                    $this->setSnackbar('Post created successfully!', 'success');
                    $this->redirect('');
                } else {
                    $this->setSnackbar('Unable to create post. Please try again later.', 'error');
                }
            }
        }

        $this->view('post/form', ['title' => 'Add Question', 'modules' => $modules]);
    }

    public function index($module_id = null, $post_id = null) {
        $modules = $this->moduleModel->getAll();
        $_SESSION['modules'] = $modules;

        if ($post_id) {
            $post = $this->postModel->getById($post_id);
            if ($post) {
                $title = htmlspecialchars($post['title']) . ' - Reddit';
                $comments = $this->commentModel->getByPostId($post_id);
                $posts = [$post]; // For view compatibility
            } else {
                $title = 'Post not found - Reddit';
                $this->setSnackbar('Post not found', 'error');
                $posts = [];
            }
        } else {
            $posts = $this->postModel->getAll($module_id);
            if ($module_id) {
                $module = array_filter($modules, fn($m) => $m['module_id'] == $module_id);
                $module = reset($module);
                $title = $module ? 'Best ' . htmlspecialchars($module['module_name']) . ' Posts - Reddit' : 'Module not found - Reddit';
                if (!$module) $this->setSnackbar('Module not found', 'error');
                elseif (empty($posts)) $this->setSnackbar('No posts found in this module', 'info');
            } else {
                $title = 'Reddit - Dive into anything';
                if (empty($posts)) $this->setSnackbar('No posts available', 'info');
            }
        }

        $this->view('post/index', [
            'title' => $title,
            'posts' => $posts,
            'modules' => $modules,
            'post_id' => $post_id,
            'comments' => $comments ?? []
        ]);
    }

    public function edit($id) {
        if (!$this->isLoggedIn()) {
            $this->setSnackbar('Please log in to edit a post', 'error');
            $this->redirect('login');
        }

        $post = $this->postModel->getById($id);
        if (!$post || ($post['user_id'] != $_SESSION['user_id'] && !$this->isAdmin())) {
            $this->setSnackbar('Post not found or you are not authorized to edit it', 'error');
            $this->redirect('');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'],
                'content' => $_POST['content'],
                'image_path' => $post['image_path'],
                'module_id' => $_POST['module_id']
            ];

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image_path = $this->uploadImage('image', 'studentq/posts');
                if ($image_path) {
                    $data['image_path'] = $image_path;
                } else {
                    $this->setSnackbar('Failed to upload image.', 'error');
                }
            }

            if ($this->postModel->update($id, $data)) {
                $this->setSnackbar('Post updated successfully!', 'success');
                $this->redirect("post/$id");
            } else {
                $this->setSnackbar('Unable to update post.', 'error');
            }
        }

        $modules = $this->moduleModel->getAll();
        $this->view('post/form', [
            'title' => 'Edit Question',
            'post' => $post,
            'modules' => $modules
        ]);
    }

    public function delete($id) {
        if (!$this->isLoggedIn()) {
            $this->setSnackbar('Please log in to delete a post', 'error');
            $this->redirect('login');
        }

        $post = $this->postModel->getById($id);
        if (!$post || ($post['user_id'] != $_SESSION['user_id'] && !$this->isAdmin())) {
            $this->setSnackbar('Post not found or you are not authorized to delete it', 'error');
            $this->redirect('');
        }

        if ($this->postModel->delete($id)) {
            $this->setSnackbar('Post deleted successfully!', 'success');
        } else {
            $this->setSnackbar('Unable to delete post.', 'error');
        }
        $this->redirect('');
    }
}