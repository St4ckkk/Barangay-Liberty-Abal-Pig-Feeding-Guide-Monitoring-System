<?php
require_once '../core/Database.php';
require_once '../core/guidelinesController.php';
require_once '../core/notificationController.php';

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: index.php');
    exit();
}

$guidelines = (new guidelinesController())->getFeedingGuidelines();
$success = '';
$error = '';


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Feeding Guidelines</title>
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

        tr td {
            font-size: 12px;
        }

        thead th {
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
            <h1>Feeding Guidelines</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Guidelines</li>
                    <li class="breadcrumb-item active">Feeding</li>
                </ol>
            </nav>
        </div>

        <section class="section">
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
                            <span>Feeding Guidelines</span>
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
                                                <th data-sortable="true">Title</th>
                                                <th data-sortable="true">Growth Stage</th>
                                                <th data-sortable="true">Weight Range</th>
                                                <th data-sortable="true">Feed Type</th>
                                                <th data-sortable="true">Protein Content</th>
                                                <th data-sortable="true">Feeding Frequency</th>
                                                <th data-sortable="true">Amount/Feeding</th>
                                                <th data-sortable="true">Special Instructions</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($guidelines)) : ?>
                                                <?php foreach ($guidelines as $guideline) : ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($guideline['title']) ?></td>
                                                        <td><?= htmlspecialchars($guideline['pig_stage']) ?></td>
                                                        <td><?= htmlspecialchars($guideline['weight_range']) ?></td>
                                                        <td><?= htmlspecialchars($guideline['feed_type']) ?></td>
                                                        <td><?= htmlspecialchars($guideline['protein_content']) ?>%</td>
                                                        <td><?= htmlspecialchars($guideline['feeding_frequency']) ?></td>
                                                        <td><?= htmlspecialchars($guideline['amount_per_feeding']) ?> kg</td>
                                                        <td><?= htmlspecialchars($guideline['special_instructions']) ?> kg</td>
                                                        <td>
                                                            <button class="btn btn-primary btn-edit" data-guideline='<?= json_encode($guideline) ?>'>
                                                                <i class="bi bi-pencil"></i>
                                                            </button>
                                                            <button class="btn btn-danger btn-delete" data-guide-id="<?= $guideline['guide_id'] ?>">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </td>

                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="8">No Guidelines found.</td>
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

        <!-- Add New Feeding Guideline Modal -->
        <div class="modal fade" id="addGuidelines" tabindex="-1" aria-labelledby="addGuidelinesLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addGuidelinesLabel">Add New Feeding Guideline</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="addFeedingGuidelines.php" method="POST">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="pigStage" class="form-label">Pig Growth Stage</label>
                                    <select class="form-select" id="pigStage" name="pigStage" required>
                                        <option value="">Select stage</option>
                                        <option value="newborn">Newborn (0-3 weeks)</option>
                                        <option value="weaner">Weaner (3-10 weeks)</option>
                                        <option value="grower">Grower (10-22 weeks)</option>
                                        <option value="finisher">Finisher (22+ weeks)</option>
                                        <option value="sow">Gestating Sow</option>
                                        <option value="lactating">Lactating Sow</option>
                                        <option value="boar">Boar</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="weightRange" class="form-label">Weight Range (kg)</label>
                                    <input type="text" class="form-control" id="weightRange" name="weightRange" placeholder="e.g., 20-50">
                                </div>
                                <div class="col-md-6">
                                    <label for="feedType" class="form-label">Feed Type</label>
                                    <input type="text" class="form-control" id="feedType" name="feedType" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="proteinContent" class="form-label">Protein Content (%)</label>
                                    <input type="number" class="form-control" id="proteinContent" name="proteinContent" step="0.1" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="feedingFrequency" class="form-label">Feeding Frequency</label>
                                    <input type="text" class="form-control" id="feedingFrequency" name="feedingFrequency" placeholder="e.g., 3 times daily">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="amountPerFeeding" class="form-label">Amount per Feeding (kg)</label>
                                    <input type="number" class="form-control" id="amountPerFeeding" name="amountPerFeeding" step="0.1" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="specialInstructions" class="form-label">Special Instructions</label>
                                <textarea class="form-control" id="specialInstructions" name="specialInstructions" rows="3"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Edit Feeding Guideline Modal -->
        <div class="modal fade" id="editGuidelines" tabindex="-1" aria-labelledby="editGuidelinesLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editGuidelinesLabel">Edit Feeding Guideline</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editGuidelineForm" action="updateFeedingGuidelines.php" method="POST">
                            <input type="hidden" name="guide_id" id="editGuideId">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="editTitle" class="form-label">Title</label>
                                    <input type="text" class="form-control" id="editTitle" name="title" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="editPigStage" class="form-label">Pig Growth Stage</label>
                                    <select class="form-select" id="editPigStage" name="pigStage" required>
                                        <option value="">Select stage</option>
                                        <option value="newborn">Newborn (0-3 weeks)</option>
                                        <option value="weaner">Weaner (3-10 weeks)</option>
                                        <option value="grower">Grower (10-22 weeks)</option>
                                        <option value="finisher">Finisher (22+ weeks)</option>
                                        <option value="sow">Gestating Sow</option>
                                        <option value="lactating">Lactating Sow</option>
                                        <option value="boar">Boar</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="editWeightRange" class="form-label">Weight Range (kg)</label>
                                    <input type="text" class="form-control" id="editWeightRange" name="weightRange" placeholder="e.g., 20-50">
                                </div>
                                <div class="col-md-6">
                                    <label for="editFeedType" class="form-label">Feed Type</label>
                                    <input type="text" class="form-control" id="editFeedType" name="feedType" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="editProteinContent" class="form-label">Protein Content (%)</label>
                                    <input type="number" class="form-control" id="editProteinContent" name="proteinContent" step="0.1" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="editFeedingFrequency" class="form-label">Feeding Frequency</label>
                                    <input type="text" class="form-control" id="editFeedingFrequency" name="feedingFrequency">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="editAmountPerFeeding" class="form-label">Amount per Feeding (kg)</label>
                                    <input type="number" class="form-control" id="editAmountPerFeeding" name="amountPerFeeding" step="0.1" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="editSpecialInstructions" class="form-label">Special Instructions</label>
                                <textarea class="form-control" id="editSpecialInstructions" name="specialInstructions" rows="3"></textarea>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Delete Feeding Guideline Modal -->
        <div class="modal fade" id="deleteGuidelines" tabindex="-1" aria-labelledby="deleteGuidelinesLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <form id="deleteGuidelineForm" action="deleteFeedingGuidelines.php" method="POST">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">Delete Guidelines</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="guide_id" id="deleteGuideId">
                                <p>Are you sure you want to delete this guideline?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </main>

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
        // Handle Edit Button Click
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', function() {
                const guideline = JSON.parse(this.getAttribute('data-guideline'));

                // Populate modal fields
                document.getElementById('editGuideId').value = guideline.guide_id;
                document.getElementById('editTitle').value = guideline.title;
                document.getElementById('editPigStage').value = guideline.pig_stage;
                document.getElementById('editWeightRange').value = guideline.weight_range;
                document.getElementById('editFeedType').value = guideline.feed_type;
                document.getElementById('editProteinContent').value = guideline.protein_content;
                document.getElementById('editFeedingFrequency').value = guideline.feeding_frequency;
                document.getElementById('editAmountPerFeeding').value = guideline.amount_per_feeding;
                document.getElementById('editSpecialInstructions').value = guideline.special_instructions;

                // Show the modal
                new bootstrap.Modal(document.getElementById('editGuidelines')).show();
            });
        });

        // Handle Delete Button Click
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function() {
                const guideId = this.getAttribute('data-guide-id');

                // Set guide ID in the delete form
                document.getElementById('deleteGuideId').value = guideId;

                // Show the modal
                new bootstrap.Modal(document.getElementById('deleteGuidelines')).show();
            });
        });
    </script>
</body>

</html>