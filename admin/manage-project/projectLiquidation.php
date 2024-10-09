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

    <title>Project Liquidation</title>
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
</head>

<body>
    <?php
    include_once '../partials/navbar.php';
    include_once '../partials/sidebar.php';
    ?>

    <main id="main" class="main" style="margin-top: 100px;">
        <div class="pagetitle">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Project Liquidation</h1>
            </div>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Project Liquidation</li>
                </ol>
            </nav>
        </div>

        <section class="section dashboard">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Project Liquidation</h5>
                            <form id="liquidationForm">
                                <div class="mb-3">
                                    <label for="projectSelect" class="form-label">Select Project</label>
                                    <select class="form-select" id="projectSelect" required>
                                        <option value="">Choose a project...</option>
                                        <?php foreach ($projects as $project): ?>
                                            <option value="<?php echo $project['project_id']; ?>"><?php echo htmlspecialchars($project['project_name']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div id="liquidationDetails" style="display: none;">
                                    <div class="mb-3">
                                        <label class="form-label">Materials</label>
                                        <div id="materialsList"></div>
                                        <button type="button" class="btn btn-secondary btn-sm mt-2" id="addMaterial">Add Material</button>
                                    </div>

                                    <div class="mb-3">
                                        <label for="receipt" class="form-label">Receipt</label>
                                        <textarea id="receipt" class="form-control" rows="5" readonly></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <strong>Total Cost: </strong><span id="totalCost">0.00</span>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Submit Liquidation</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/main.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const projectSelect = document.getElementById('projectSelect');
            const liquidationDetails = document.getElementById('liquidationDetails');
            const materialsList = document.getElementById('materialsList');
            const addMaterialBtn = document.getElementById('addMaterial');
            const liquidationForm = document.getElementById('liquidationForm');
            const receiptTextarea = document.getElementById('receipt');
            const totalCostDisplay = document.getElementById('totalCost');

            let totalCost = 0;

            projectSelect.addEventListener('change', function() {
                if (this.value) {
                    liquidationDetails.style.display = 'block';
                    loadMaterials(this.value);
                } else {
                    liquidationDetails.style.display = 'none';
                }
            });

            addMaterialBtn.addEventListener('click', addMaterialRow);

            liquidationForm.addEventListener('submit', function(e) {
                e.preventDefault();
                submitLiquidation();
            });

            function loadMaterials(projectId) {
                materialsList.innerHTML = '';
                addMaterialRow();
            }

            function addMaterialRow() {
                const row = document.createElement('div');
                row.className = 'row mb-2';
                row.innerHTML = ` 
                    <div class="col-md-3">
                        <input type="text" class="form-control" placeholder="Material Name" required>
                    </div>
                    <div class="col-md-2">
                        <input type="number" class="form-control" placeholder="Quantity" required>
                    </div>
                    <div class="col-md-2">
                        <input type="number" class="form-control amount" placeholder="Amount" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control or-number" placeholder="OR Number" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-sm remove-material">Remove</button>
                    </div>
                `;
                materialsList.appendChild(row);


                const amountInput = row.querySelector('.amount');
                amountInput.addEventListener('input', function() {
                    updateTotalCost();
                });

                row.querySelector('.remove-material').addEventListener('click', function() {
                    row.remove();
                    updateTotalCost();
                });


                const quantityInput = row.querySelector('input[type="number"]');
                quantityInput.addEventListener('input', function() {
                    updateTotalCost();
                });


                const orNumberInput = row.querySelector('.or-number');
                orNumberInput.addEventListener('input', function() {
                    updateReceipt();
                });
            }

            function updateTotalCost() {
                totalCost = 0;
                const rows = materialsList.querySelectorAll('.row');

                rows.forEach(row => {
                    const quantity = row.querySelector('input[type="number"]').value;
                    const amount = row.querySelector('.amount').value;
                    totalCost += (parseInt(quantity) || 0) * (parseFloat(amount) || 0);
                });

                totalCostDisplay.textContent = totalCost.toFixed(2);
                updateReceipt();
            }

            function updateReceipt() {
                let receiptContent = 'Receipt:\n\n';
                const rows = materialsList.querySelectorAll('.row');

                rows.forEach(row => {
                    const materialName = row.querySelector('input[type="text"]').value.trim();
                    const quantity = row.querySelector('input[type="number"]').value;
                    const amount = row.querySelector('.amount').value;
                    const orNumber = row.querySelector('.or-number').value.trim();
                    if (materialName && quantity && amount) {
                        receiptContent += `Material: ${materialName}, Quantity: ${quantity}, Amount: ${amount}, OR Number: ${orNumber}\n`;
                    }
                });

                receiptContent += `\nTotal Cost: ${totalCost.toFixed(2)}`;
                receiptTextarea.value = receiptContent;
            }

            function submitLiquidation() {
                console.log('Submitting liquidation...');

            }
        });
    </script>
</body>

</html>