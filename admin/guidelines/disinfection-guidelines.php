<?php
require_once '../core/Database.php';
require_once '../core/guidelinesController.php';
require_once '../core/notificationController.php';

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: index.php');
    exit();
}

$notificationController = new notificationController();
$currentTime = date('Y-m-d H:i:s');
$notifications = $notificationController->getNotification();

$guidelines = (new guidelinesController())->getCleaningGuidelines();
$success = '';
$error = '';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Cleaning Guidelines</title>
    <meta content="Dashboard for pig feeding guide and monitoring" name="description">
    <meta content="pig, feeding, monitoring, dashboard" name="keywords">

    <link href="../assets/img/pig-logo.png" rel="icon">
    <link href="../assets/img/pig-logo.png" rel="apple-touch-icon">

    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <link href="../assets/css/global.css" rel="stylesheet">

    <style>
        .btn {
            width: 60px;
            padding: 2px;
            font-size: 12px;
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
            <h1>Cleaning Guidelines</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Guidelines</li>
                    <li class="breadcrumb-item active">Cleaning</li>
                </ol>
            </nav>
        </div>

        <section class="section ">
            <?php
            if (isset($_SESSION['error'])) {
                echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error'] . '</div>';
                unset($_SESSION['error']);
            }

            if (isset($_SESSION['success'])) {
                echo '<div class="alert alert-success" role="alert">' . $_SESSION['success'] . '</div>';
                unset($_SESSION['success']);
            }
            ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header mb-2">
                            <span>Pig Cleaning Guidelines</span>
                        </div>
                        <div class="card-body">
                            <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                                <div class="datatable-top">
                                    <div class="datatable-dropdown">
                                        <div class="float-end">
                                            <button type="button" class="btn btn-primary float-end mb-3" data-bs-toggle="modal" data-bs-target="#addGuidelines">
                                                Add <i class="bi bi-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="datatable-search">
                                        <input class="datatable-input" placeholder="Search..." type="search" name="search" title="Search within table">
                                    </div>
                                </div>
                                <div class="datatable-container">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Category</th>
                                                <th>Description</th>
                                                <th>Frequency</th>
                                                <th>Importance</th>
                                                <th>Equipment</th>
                                                <th>Safety</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($guidelines)) : ?>
                                                <?php foreach ($guidelines as $guideline) : ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($guideline['title']) ?></td>
                                                        <td><?= htmlspecialchars($guideline['category']) ?></td>
                                                        <td><?= htmlspecialchars($guideline['description']) ?></td>
                                                        <td><?= htmlspecialchars($guideline['frequency']) ?></td>
                                                        <td><?= htmlspecialchars($guideline['importance']) ?></td>
                                                        <td><?= htmlspecialchars($guideline['equipment']) ?></td>
                                                        <td><?= htmlspecialchars($guideline['safety']) ?></td>
                                                        <td>
                                                            <a href="#" class="btn btn-primary btn-action edit"
                                                                data-id="<?= $guideline['id'] ?>"
                                                                data-title="<?= htmlspecialchars($guideline['title']) ?>"
                                                                data-category="<?= htmlspecialchars($guideline['category']) ?>"
                                                                data-description="<?= htmlspecialchars($guideline['description']) ?>"
                                                                data-frequency="<?= htmlspecialchars($guideline['frequency']) ?>"
                                                                data-importance="<?= htmlspecialchars($guideline['importance']) ?>"
                                                                data-equipment="<?= htmlspecialchars($guideline['equipment']) ?>"
                                                                data-safety="<?= htmlspecialchars($guideline['safety']) ?>">
                                                                <i class="bi bi-pencil"></i>
                                                            </a>

                                                            <a href="#" class="btn btn-danger btn-action delete"
                                                                data-id="<?= $guideline['id'] ?>">
                                                                <i class="bi bi-trash"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td colspan="5">No cleaning guidelines found.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="datatable-bottom">
                                    <div class="datatable-info">Showing 1 to 10 of 100 entries</div>
                                    <nav class="datatable-pagination">
                                        <ul class="datatable-pagination-list">
                                            <li class="datatable-pagination-list-item datatable-hidden datatable-disabled"><button data-page="1" class="datatable-pagination-list-item-link" aria-label="Page 1">‹</button></li>
                                            <li class="datatable-pagination-list-item datatable-active"><button data-page="1" class="datatable-pagination-list-item-link" aria-label="Page 1">1</button></li>
                                            <li class="datatable-pagination-list-item"><button data-page="2" class="datatable-pagination-list-item-link" aria-label="Page 2">2</button></li>
                                            <li class="datatable-pagination-list-item"><button data-page="3" class="datatable-pagination-list-item-link" aria-label="Page 3">3</button></li>
                                            <li class="datatable-pagination-list-item"><button data-page="4" class="datatable-pagination-list-item-link" aria-label="Page 4">4</button></li>
                                            <li class="datatable-pagination-list-item"><button data-page="5" class="datatable-pagination-list-item-link" aria-label="Page 5">5</button></li>
                                            <li class="datatable-pagination-list-item"><button data-page="6" class="datatable-pagination-list-item-link" aria-label="Page 6">6</button></li>
                                            <li class="datatable-pagination-list-item"><button data-page="7" class="datatable-pagination-list-item-link" aria-label="Page 7">7</button></li>
                                            <li class="datatable-pagination-list-item datatable-ellipsis datatable-disabled"><button class="datatable-pagination-list-item-link">…</button></li>
                                            <li class="datatable-pagination-list-item"><button data-page="10" class="datatable-pagination-list-item-link" aria-label="Page 10">10</button></li>
                                            <li class="datatable-pagination-list-item"><button data-page="2" class="datatable-pagination-list-item-link" aria-label="Page 2">›</button></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Add New Cleaning Guideline Modal -->
    <div class="modal fade" id="addGuidelines" tabindex="-1" aria-labelledby="addGuidelinesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addGuidelinesModalLabel">Add New Cleaning Guideline</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="addCleaningGuideline.php" method="POST">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="col-md-6">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-select" id="category" name="category" required>
                                    <option value="">Select a category</option>
                                    <option value="daily">Daily Cleaning</option>
                                    <option value="weekly">Weekly Cleaning</option>
                                    <option value="monthly">Monthly Maintenance</option>
                                    <option value="equipment">Equipment Cleaning</option>
                                    <option value="biosecurity">Biosecurity Measures</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="frequency" class="form-label">Frequency</label>
                                <select class="form-select" id="frequency" name="frequency" required>
                                    <option value="">Select frequency</option>
                                    <option value="daily">Daily</option>
                                    <option value="weekly">Weekly</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="quarterly">Quarterly</option>
                                    <option value="as_needed">As Needed</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="importance" class="form-label">Importance</label>
                                <select class="form-select" id="importance" name="importance" required>
                                    <option value="">Select importance</option>
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                    <option value="critical">Critical</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="equipment" class="form-label">Required Equipment</label>
                            <input type="text" class="form-control" id="equipment" name="equipment" placeholder="e.g., Brushes, Disinfectant, Pressure Washer">
                        </div>
                        <div class="mb-3">
                            <label for="safety" class="form-label">Safety Precautions</label>
                            <textarea class="form-control" id="safety" name="safety" rows="2" placeholder="Any safety measures to be taken"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Save Cleaning Guideline</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </section>

    </main>

    <!-- Edit Cleaning Guideline Modal -->
    <div class="modal fade" id="editGuidelineModal" tabindex="-1" aria-labelledby="editGuidelineModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editGuidelineModalLabel">Edit Cleaning Guideline</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="updateCleaningGuidelines.php" method="POST">
                        <input type="hidden" id="editGuidelineId" name="id" value="">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="editTitle" class="form-label">Title</label>
                                <input type="text" class="form-control" id="editTitle" name="title" required>
                            </div>
                            <div class="col-md-6">
                                <label for="editCategory" class="form-label">Category</label>
                                <select class="form-select" id="editCategory" name="category" required>
                                    <option value="">Select a category</option>
                                    <option value="daily">Daily Cleaning</option>
                                    <option value="weekly">Weekly Cleaning</option>
                                    <option value="monthly">Monthly Maintenance</option>
                                    <option value="equipment">Equipment Cleaning</option>
                                    <option value="biosecurity">Biosecurity Measures</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="editDescription" name="description" rows="4" required></textarea>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="editFrequency" class="form-label">Frequency</label>
                                <select class="form-select" id="editFrequency" name="frequency" required>
                                    <option value="">Select frequency</option>
                                    <option value="daily">Daily</option>
                                    <option value="weekly">Weekly</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="quarterly">Quarterly</option>
                                    <option value="as_needed">As Needed</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="editImportance" class="form-label">Importance</label>
                                <select class="form-select" id="editImportance" name="importance" required>
                                    <option value="">Select importance</option>
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                    <option value="critical">Critical</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="editEquipment" class="form-label">Equipment</label>
                                <input type="text" class="form-control" id="editEquipment" name="equipment">
                            </div>
                            <div class="mb-3">
                                <label for="editSafety" class="form-label">Safety</label>
                                <input type="text" class="form-control" id="editSafety" name="safety">
                            </div>

                        </div>
                        <button type="submit" class="btn btn-primary w-100">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteGuidelineModal" tabindex="-1" aria-labelledby="deleteGuidelineModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteGuidelineModalLabel">Delete Guideline</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this cleaning guideline?
                </div>
                <div class="modal-footer">
                    <form action="deleteCleaningGuideline.php" method="POST">
                        <input type="hidden" id="deleteGuidelineId" name="id" value="">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>


    <script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/chart.js/chart.umd.js"></script>
    <script src="../assets/vendor/echarts/echarts.min.js"></script>
    <script src="../assets/vendor/quill/quill.js"></script>
    <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="../assets/vendor/php-email-form/validate.js"></script>

    <script src="../assets/js/main.js"></script>
    <script>
        // Attach event listeners to edit buttons
        document.querySelectorAll('.btn-action.edit').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const title = this.getAttribute('data-title');
                const category = this.getAttribute('data-category');
                const description = this.getAttribute('data-description');
                const frequency = this.getAttribute('data-frequency');
                const importance = this.getAttribute('data-importance');
                const equipment = this.getAttribute('data-equipment');
                const safety = this.getAttribute('data-safety');

                document.getElementById('editGuidelineId').value = id;
                document.getElementById('editTitle').value = title;
                document.getElementById('editCategory').value = category;
                document.getElementById('editDescription').value = description;
                document.getElementById('editFrequency').value = frequency;
                document.getElementById('editImportance').value = importance;
                document.getElementById('editEquipment').value = equipment;
                document.getElementById('editSafety').value = safety;

                // Open the modal
                const editModal = new bootstrap.Modal(document.getElementById('editGuidelineModal'));
                editModal.show();
            });
        });

        // Attach event listeners to delete buttons
        document.querySelectorAll('.btn-action.delete').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                document.getElementById('deleteGuidelineId').value = id;

                // Open the modal
                const deleteModal = new bootstrap.Modal(document.getElementById('deleteGuidelineModal'));
                deleteModal.show();
            });
        });
    </script>
</body>

</html>