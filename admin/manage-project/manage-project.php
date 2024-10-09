<?php
require_once '../core/projectController.php';
$projectController = new projectController();

$notif = new projectController();
$notifications = $notif->getProjectNotif();
$notificationCount = $notif->getNotificationCount();
$projects = $projectController->getProjects();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Project Management</title>
    <meta content="Project Management Dashboard" name="description">
    <meta content="projects, management, dashboard" name="keywords">

    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">
    <link href="../assets/css/globalss.css" rel="stylesheet">
    <style>
        .project-card {
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .project-card h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .project-card p {
            font-size: 14px;
            color: #666;
        }

        .progress {
            height: 10px;
            margin-bottom: 10px;
        }

        .project-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .project-team img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: -10px;
            border: 2px solid #fff;
        }

        .time-left {
            font-size: 12px;
            background-color: #e9ecef;
            padding: 5px 10px;
            border-radius: 20px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .add-project-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .add-project-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <?php
    include_once '../partials/navbar.php';
    include_once '../partials/sidebar.php';
    ?>

    <main id="main" class="main" style="margin-top: 100px;">
        <div class="pagetitle">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Projects</h1>
                <div class="header-actions">
                    <button class="add-project-btn" data-bs-toggle="modal" data-bs-target="#addProjectModal">
                        <i class="bi bi-plus"></i> Add Project
                    </button>
                </div>
            </div>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Projects</li>
                </ol>
            </nav>
        </div>

        <section class="section dashboard">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <!-- Project Summary -->
                        <div class="col-xxl-3 col-md-6">
                            <div class="card info-card sales-card">
                                <div class="card-body">
                                    <h5 class="card-title">Hearing</h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-clock-history"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6">
                            <div class="card info-card revenue-card">
                                <div class="card-body">
                                    <h5 class="card-title">Approved</h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-check-circle"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6">
                            <div class="card info-card customers-card">
                                <div class="card-body">
                                    <h5 class="card-title">Declined</h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-x-circle"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6">
                            <div class="card info-card sales-card">
                                <div class="card-body">
                                    <h5 class="card-title">Total Projects</h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-folder"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="row">
                        <?php foreach ($projects as $project): ?>
                            <div class="col-md-4">
                                <a href="<?php echo 'projectOverview.php?project_id=' . $project['project_id']; ?>">
                                    <div class="project-card" style="background-color: #FFE5B4;">
                                        <h3><?php echo htmlspecialchars($project['project_name']); ?></h3>
                                        <p><?php echo htmlspecialchars($project['project_description']); ?></p>
                                        <div class="project-meta">
                                            <span class="time-left"><?php echo htmlspecialchars($project['project_duration']); ?> </span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <div class="modal fade" id="addProjectModal" tabindex="-1" aria-labelledby="addProjectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProjectModalLabel">Add New Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addProjectForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="projectName" class="form-label">Project Name</label>
                                <input type="text" class="form-control" id="projectName" name="projectName" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="projectCode" class="form-label">Project Code</label>
                                <input type="text" class="form-control" id="projectCode" name="projectCode" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="projectCode" class="form-label">Project Duration (In Days)</label>
                                <input type="text" class="form-control" id="projectCode" name="projectDuration">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="projectDescription" class="form-label">Project Description</label>
                            <textarea class="form-control" id="projectDescription" name="projectDescription" rows="3" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="specificJob" class="form-label">Specific Job</label>
                                <input type="text" class="form-control" id="specificJob" name="specificJob" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="operations" class="form-label">Operations</label>
                                <input type="text" class="form-control" id="operations" name="operations" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="materials" class="form-label">Material</label>
                                <input type="text" class="form-control" id="materials" placeholder="e.g., Cement">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="quantity" placeholder="e.g., 5">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="amount" class="form-label">Amount (₱ per unit)</label>
                                <input type="number" class="form-control" id="amount" placeholder="e.g., 100">
                            </div>
                        </div>
                        <button type="button" class="btn btn-info mb-3" onclick="addMaterial()">Add Material</button>
                        <div id="materialList"></div>
                        <div class="mb-3">
                            <label for="receipt" class="form-label">Materials Total Cost</label>
                            <textarea class="form-control" id="receipt" rows="8" readonly></textarea>
                        </div>
                        <div class="mb-3">
                            <input type="hidden" class="form-control" id="totalCost" name="totalCost" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="proposal" class="form-label">Project Proposal</label>
                            <input type="file" class="form-control" id="proposal" name="proposal" accept=".pdf,.doc,.docx">
                        </div>
                        <button type="button" class="btn btn-primary" onclick="submitProject()">Submit Project</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitProject()">Submit Project</button>
                </div>
            </div>
        </div>
    </div>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Your existing JS files -->
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/main.js"></script>

    <script>
        let materialsArray = [];

        function generateProjectCode() {
            const prefix = "SKP-";
            const randomNum = Math.floor(Math.random() * 9000) + 1000;
            return prefix + randomNum;
        }

        function setProjectCode() {
            document.getElementById('projectCode').value = generateProjectCode();
        }

        window.onload = setProjectCode;

        function addMaterial() {
            const materialName = document.getElementById('materials').value;
            const quantity = parseFloat(document.getElementById('quantity').value);
            const amount = parseFloat(document.getElementById('amount').value);

            if (!materialName || isNaN(quantity) || isNaN(amount)) {
                alert('Please enter valid values for all material fields.');
                return;
            }

            materialsArray.push({
                materialName,
                quantity,
                amount
            });

            document.getElementById('materials').value = '';
            document.getElementById('quantity').value = '';
            document.getElementById('amount').value = '';

            renderMaterialsList();
            calculateTotalCost();
            updateReceipt();
        }

        function renderMaterialsList() {
            const materialListDiv = document.getElementById('materialList');
            materialListDiv.innerHTML = '';

            materialsArray.forEach((material, index) => {
                const materialItem = document.createElement('div');
                materialItem.className = 'row mb-2';
                materialItem.innerHTML = `
                    <div class="col-md-4">${material.materialName}</div>
                    <div class="col-md-4">${material.quantity}</div>
                    <div class="col-md-4">₱${material.amount}</div>
                `;
                materialListDiv.appendChild(materialItem);
            });
        }

        function calculateTotalCost() {
            let totalCost = materialsArray.reduce((sum, material) => sum + material.quantity * material.amount, 0);
            document.getElementById('totalCost').value = totalCost.toFixed(2);
        }

        function updateReceipt() {
            let receiptText = `--- MATERIALS TOTAL COST ---\n\n`;
            receiptText += `Item             Qty     Price     Total\n`;
            receiptText += `-----------------------------------------\n`;

            materialsArray.forEach(material => {
                const total = material.quantity * material.amount;
                receiptText += `${material.materialName.padEnd(15)} ${material.quantity.toString().padEnd(6)} ₱${material.amount.toFixed(2).padEnd(8)} ₱${total.toFixed(2)}\n`;
            });

            let totalCost = materialsArray.reduce((sum, material) => sum + material.quantity * material.amount, 0);

            receiptText += `-----------------------------------------\n`;
            receiptText += `Total Cost:                         ₱${totalCost.toFixed(2)}\n`;

            document.getElementById('receipt').value = receiptText;
        }

        function submitProject() {
            const formData = new FormData(document.getElementById('addProjectForm'));
            formData.append('materials', JSON.stringify(materialsArray));
            formData.append('status', 'hearing'); // Set default status

            fetch('addProject.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.statusText);
                    }
                    return response.text();
                })
                .then(text => {
                    try {
                        const data = JSON.parse(text);
                        console.log(data);
                        if (data.success) {
                            alert(data.message || "Project submitted successfully!");
                            document.getElementById('addProjectForm').reset();
                            materialsArray = [];
                            renderMaterialsList();
                            updateReceipt();
                        } else {
                            alert(data.message || "Failed to submit the project.");
                        }
                    } catch (error) {
                        console.error('Error parsing JSON:', error);
                        console.log('Raw response:', text);
                        alert("An error occurred while processing the response.");
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert("An error occurred: " + error.message);
                });
        }
    </script>

</body>

</html>