<?php
header('Content-Type: application/json');

require_once '../core/projectController.php';
$projectController = new projectController();

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $project_name = $_POST['projectName'] ?? null;
    $project_code = $_POST['projectCode'] ?? null;
    $project_description = $_POST['projectDescription'] ?? null;
    $project_duration = $_POST['projectDuration'] ?? null;
    $status = $_POST['status'] ?? 'hearing';
    $specific_job = $_POST['specificJob'] ?? null;
    $operations = $_POST['operations'] ?? null;
    $total_cost = $_POST['totalCost'] ?? null;
    $materials = isset($_POST['materials']) ? $_POST['materials'] : '[]';

    $proposal_file_path = null;
    if (isset($_FILES['proposal']) && $_FILES['proposal']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['proposal']['tmp_name'];
        $proposal_file_path = 'uploads/' . basename($_FILES['proposal']['name']);
        move_uploaded_file($tmp_name, $proposal_file_path);
    }

    if (empty($project_name) || empty($project_code) || empty($project_description) || empty($project_duration) || empty($status) || empty($specific_job) || empty($operations) || empty($total_cost)) {
        $error = "All fields are required!";
    } else {
        try {
            // Pass the materials argument
            $result = $projectController->createProject(
                $project_name,
                $project_code,
                $project_description,
                $project_duration,
                $status,
                $specific_job,
                $operations,
                $total_cost,
                $proposal_file_path,
                $materials // Ensure materials are passed here
            );
            if ($result) {
                $success = "Project added successfully!";
            } else {
                $error = "Failed to add project!";
            }
        } catch (Exception $e) {
            $error = "An error occurred: " . $e->getMessage();
        }
    }
}

if ($success) {
    echo json_encode(['success' => true, 'message' => $success]);
} else {
    echo json_encode(['success' => false, 'message' => $error]);
}
exit;
