<?php
class ModuleController extends BaseController {
    private $moduleModel;

    public function __construct($pdo) {
        parent::__construct($pdo);
        $this->moduleModel = $this->loadModel('Module');
    }

    public function index() {
        $modules = $this->moduleModel->getAll();
        $_SESSION['modules'] = $modules;

        if (empty($modules)) {
            $this->setSnackbar('No modules available', 'info');
        }

        $this->view('module/index', ['title' => 'Manage Modules', 'modules' => $modules]);
    }

    public function add() {
        $name = trim($_POST['module_name'] ?? '');
        if (strlen($name) < 3) {
            $this->setSnackbar('Module name must be 3 or more characters', 'error');
        } elseif ($this->moduleModel->nameExists($name)) {
            $this->setSnackbar('A module with this name already exists', 'error');
        } elseif ($this->moduleModel->create($name)) {
            $this->setSnackbar('Module added successfully!', 'success');
        } else {
            $this->setSnackbar('Unable to add module. Please try again later.', 'error');
        }
        $this->redirect('module');
    }

    public function edit($id) {
        $name = trim($_POST['module_name'] ?? '');
        if (strlen($name) < 3) {
            $this->setSnackbar('Module name must be 3 or more characters', 'error');
        } elseif ($this->moduleModel->nameExists($name, $id)) {
            $this->setSnackbar('A module with this name already exists', 'error');
        } elseif ($this->moduleModel->update($id, $name)) {
            $this->setSnackbar('Module updated successfully!', 'success');
        } else {
            $this->setSnackbar('Unable to update module. Please try again later.', 'error');
        }
        $this->redirect('module');
    }

    public function delete($id) {
        if ($this->moduleModel->delete($id)) {
            $this->setSnackbar('Module deleted successfully!', 'success');
        } else {
            $this->setSnackbar('Unable to delete module. Please try again later.', 'error');
        }
        $this->redirect('module');
    }
}