<?php
// models/Module.php
class Module {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM modules");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($name) {
        $stmt = $this->pdo->prepare("INSERT INTO modules (module_name) VALUES (?)");
        return $stmt->execute([$name]);
    }

    public function update($id, $name) {
        $stmt = $this->pdo->prepare("UPDATE modules SET module_name = ? WHERE module_id = ?");
        return $stmt->execute([$name, $id]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM modules WHERE module_id = ?");
        return $stmt->execute([$id]);
    }

    public function nameExists($name, $excludeId = null) {
        $query = "SELECT COUNT(*) FROM modules WHERE module_name = ?";
        $params = [$name];
        if ($excludeId) {
            $query .= " AND module_id != ?";
            $params[] = $excludeId;
        }
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

    public function findById($id) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM modules WHERE module_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetchColumn() > 0;
    }
}