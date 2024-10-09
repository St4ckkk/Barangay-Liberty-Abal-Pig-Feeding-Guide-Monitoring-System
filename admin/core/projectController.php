<?php

include_once 'Database.php';

class projectController
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function createProject(
        $project_name,
        $project_code,
        $project_description,
        $project_duration,
        $status,
        $specific_job,
        $operations,
        $total_cost,
        $proposal_file_path,
        $materials
    ) {
        $this->db->beginTransaction();

        try {
            $query = "INSERT INTO projects(project_name, project_code, project_description, project_duration, status, specific_job, operations, total_cost, proposal_file_path) VALUES (:project_name, :project_code, :project_description, :project_duration, :status, :specific_job, :operations, :total_cost, :proposal_file_path)";
            $stmt = $this->db->prepare($query);
            $params = [
                ':project_name' => $project_name,
                ':project_code' => $project_code,
                ':project_description' => $project_description,
                ':project_duration' => $project_duration,
                ':status' => $status,
                ':specific_job' => $specific_job,
                ':operations' => $operations,
                ':total_cost' => $total_cost,
                ':proposal_file_path' => $proposal_file_path
            ];
            $stmt->execute($params);

            $project_id = $this->db->lastInsertId();

            $materials = json_decode($materials, true);
            $materialQuery = "INSERT INTO materials(project_id, material_name, quantity, amount) VALUES (:project_id, :material_name, :quantity, :amount)";
            $materialStmt = $this->db->prepare($materialQuery);

            foreach ($materials as $material) {
                $materialParams = [
                    ':project_id' => $project_id,
                    ':material_name' => $material['materialName'],
                    ':quantity' => $material['quantity'],
                    ':amount' => $material['amount']
                ];
                $materialStmt->execute($materialParams);
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function getProjects()
    {
        $query = "SELECT * FROM projects";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getProjectByID($project_id)
    {
        $query = "SELECT * FROM projects WHERE project_id = :project_id";
        $stmt = $this->db->prepare($query);
        $params = [':project_id' => $project_id];
        $stmt->execute($params);
        return $stmt->fetch();
    }

    public function getMaterialsByProjectId($project_id)
    {
        $query = "SELECT * FROM materials WHERE project_id = :project_id";
        $stmt = $this->db->prepare($query);
        $params = [':project_id' => $project_id];
        $stmt->execute($params);
        return $stmt->fetchAll();
    }


    public function getProjectNotif()
    {
        $query = "SELECT * FROM projects WHERE status = 'Hearing'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getNotificationCount()
    {
        $query = "SELECT COUNT(*) as count FROM projects WHERE status = 'Hearing'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}
