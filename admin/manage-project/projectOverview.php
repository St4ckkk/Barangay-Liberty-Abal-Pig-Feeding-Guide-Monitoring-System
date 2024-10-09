<?php
require_once '../core/projectController.php';
$projectController = new projectController();
$notif = new projectController();
$notifications = $notif->getProjectNotif();
$notificationCount = $notif->getNotificationCount();
$projects = [];


$project_id = isset($_GET['project_id']) ? (int)$_GET['project_id'] : 0;

if ($project_id > 0) {
    $projects = $projectController->getProjectById($project_id);
    $materials = $projectController->getMaterialsByProjectId($project_id);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Project and Materials Tables</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <link href="../assets/img/favicon.png" rel="icon">
    <link href="../assets/img/SK-logo.png" rel="apple-touch-icon">

    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <link href="../assets/css/globalss.css" rel="stylesheet">

    <style>
        table {
            table-layout: auto;
            width: 100%;
            word-wrap: break-word;
        }

        th {
            white-space: nowrap;
            /* Keeps text from wrapping */
            padding: 8px 16px;
        }

        th:nth-child(1) {
            width: 20%;
        }

        th:nth-child(2),
        th:nth-child(3),
        th:nth-child(4) {
            width: 10%;
        }


        @media (min-width: 992px) {
            .datatable-container {
                overflow-x: auto;
            }
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
            <h1><b><?= $projects['project_name'] ?></b> and Materials Tables</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Tables</li>
                </ol>
            </nav>
        </div>

        <section class="section dashboard">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Manage Projects</h5>
                            <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                                <div class="datatable-top">
                                    <div class="datatable-dropdown">
                                        <label>
                                            <select class="datatable-selector" name="per-page">
                                                <option value="5">5</option>
                                                <option value="10" selected="">10</option>
                                                <option value="15">15</option>
                                                <option value="-1">All</option>
                                            </select> entries per page
                                        </label>
                                    </div>
                                    <div class="datatable-search">
                                        <input class="datatable-input" placeholder="Search..." type="search" name="search" title="Search within table">
                                    </div>
                                </div>
                                <div class="datatable-container">
                                    <table class="table datatable datatable-table">
                                        <thead>
                                            <tr>
                                                <th><b>Project Name</b></th>
                                                <th>Code</th>
                                                <th>Description</th>
                                                <th>Duration</th>
                                                <th>Status</th>
                                                <th>Specific Job</th>
                                                <th>Operation</th>
                                                <th>Cost</th>
                                                <th>Proposal</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($projects)) : ?>
                                                <tr>
                                                    <td><strong><?php echo htmlspecialchars($projects['project_name']) ?></strong></td>
                                                    <td><?php echo htmlspecialchars($projects['project_code']); ?></td>
                                                    <td><?php echo htmlspecialchars($projects['project_description']); ?></td>
                                                    <td><?php echo htmlspecialchars($projects['project_duration']); ?></td>
                                                    <td><?php echo htmlspecialchars($projects['status']); ?></td>
                                                    <td><?php echo htmlspecialchars($projects['specific_job']); ?></td>
                                                    <td><?php echo htmlspecialchars($projects['operations']); ?></td>
                                                    <td><?php echo htmlspecialchars($projects['total_cost']); ?></td>
                                                    <td>
                                                        <a href="<?php echo htmlspecialchars($projects['proposal_file_path']); ?>" download>
                                                            Download Proposal
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex justify-content-center">
                                                            <span class="icon-bg edit me-2" data-bs-toggle="modal" data-bs-target="#editModal"
                                                                data-id="<?php echo $projects['project_id']; ?>"
                                                                data-name="<?php echo htmlspecialchars($projects['project_name']); ?>"
                                                                data-code="<?php echo htmlspecialchars($projects['project_code']); ?>"
                                                                data-description="<?php echo htmlspecialchars($projects['project_description']); ?>">
                                                                <i class="bi bi-pencil"></i>
                                                            </span>
                                                            <span class="icon-bg delete" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                                data-id="<?php echo $projects['project_id']; ?>">
                                                                <i class="bi bi-trash"></i>
                                                            </span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="10">No projects found.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>

                                    </table>
                                </div>
                                <div class="datatable-bottom">
                                    <div class="datatable-info">Showing 1 to 10 of 100 entries</div>
                                    <nav class="datatable-pagination">
                                        <ul class="datatable-pagination-list">
                                            <li class="datatable-pagination-list-item datatable-disabled"><button data-page="1">‹</button></li>
                                            <li class="datatable-pagination-list-item datatable-active"><button data-page="1">1</button></li>
                                            <li class="datatable-pagination-list-item"><button data-page="2">2</button></li>
                                            <li class="datatable-pagination-list-item"><button data-page="3">3</button></li>
                                            <li class="datatable-pagination-list-item"><button data-page="4">4</button></li>
                                            <li class="datatable-pagination-list-item"><button data-page="5">5</button></li>
                                            <li class="datatable-pagination-list-item"><button data-page="2">›</button></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Materials Used</h5>
                            <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                                <div class="datatable-top">
                                    <div class="datatable-dropdown">
                                        <label>
                                            <select class="datatable-selector" name="per-page">
                                                <option value="5">5</option>
                                                <option value="10" selected="">10</option>
                                                <option value="15">15</option>
                                                <option value="-1">All</option>
                                            </select> entries per page
                                        </label>
                                    </div>
                                </div>
                                <div class="datatable-container">
                                    <table class="table datatable datatable-table">
                                        <thead>
                                            <tr>
                                                <th><b>Material</b></th>
                                                <th>Qty</th>
                                                <th>Total</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($materials)) : ?>
                                                <?php foreach ($materials as $material) : ?>
                                                    <tr>
                                                        <td><strong><?php echo htmlspecialchars($material['material_name']) ?></strong></td>
                                                        <td><?php echo htmlspecialchars($material['quantity']); ?></td>
                                                        <td><?php echo htmlspecialchars($material['total']); ?></td>
                                                        <td>
                                                            <div class="d-flex justify-content-center">
                                                                <span class="icon-bg edit me-2" data-bs-toggle="modal" data-bs-target="#editMaterialModal"
                                                                    data-id="<?php echo $material['material_id']; ?>"
                                                                    data-name="<?php echo htmlspecialchars($material['material_name']); ?>"
                                                                    data-quantity="<?php echo htmlspecialchars($material['quantity']); ?>"
                                                                    data-amount="<?php echo htmlspecialchars($material['amount']); ?>">
                                                                    <i class="bi bi-pencil"></i>
                                                                </span>
                                                                <span class="icon-bg delete" data-bs-toggle="modal" data-bs-target="#deleteMaterialModal"
                                                                    data-id="<?php echo $material['material_id']; ?>">
                                                                    <i class="bi bi-trash"></i>
                                                                </span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="4">No materials found.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="datatable-bottom">
                                    <div class="datatable-info">Showing 1 to 10 of 100 entries</div>
                                    <nav class="datatable-pagination">
                                        <ul class="datatable-pagination-list">
                                            <li class="datatable-pagination-list-item datatable-disabled"><button data-page="1">‹</button></li>
                                            <li class="datatable-pagination-list-item datatable-active"><button data-page="1">1</button></li>
                                            <li class="datatable-pagination-list-item"><button data-page="2">2</button></li>
                                            <li class="datatable-pagination-list-item"><button data-page="3">3</button></li>
                                            <li class="datatable-pagination-list-item"><button data-page="4">4</button></li>
                                            <li class="datatable-pagination-list-item"><button data-page="5">5</button></li>
                                            <li class="datatable-pagination-list-item"><button data-page="2">›</button></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/chart.js/chart.umd.js"></script>
    <script src="../assets/vendor/echarts/echarts.min.js"></script>
    <script src="../assets/vendor/quill/quill.js"></script>
    <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="../assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="../assets/js/main.js"></script>
</body>

</html>