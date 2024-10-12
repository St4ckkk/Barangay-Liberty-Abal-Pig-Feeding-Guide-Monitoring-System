<?php
require_once '../core/Database.php';
require_once '../core/settingsController.php';
require_once '../core/notificationController.php';

$notificationController = new notificationController();
$currentTime = date('Y-m-d H:i:s');
$notifications = $notificationController->getNotification();
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: index.php');
    exit();
}

$cleanings = (new settingsController())->getCleaningPeriod();
$success = '';
$error = '';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Cleaning Period</title>
    <meta content="Dashboard for pig cleaning schedule and monitoring" name="description">
    <meta content="pig, cleaning, monitoring, dashboard" name="keywords">

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
            <h1>Cleaning Period</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Settings</li>
                    <li class="breadcrumb-item active">Cleaning</li>
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
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header mb-2">
                            <span>Cleaning Period</span>
                        </div>
                        <div class="card-body">
                            <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                                <div class="datatable-top">
                                    <div class="datatable-dropdown">
                                        <div class="float-end">
                                            <!-- Add button removed as in the original -->
                                        </div>
                                    </div>
                                    <div class="datatable-search">
                                        <input class="datatable-input" placeholder="Search..." type="search" name="search" title="Search within table">
                                    </div>
                                </div>
                                <div class="datatable-container">
                                    <table class="table datatable datatable-table">
                                        <thead>
                                            <tr>
                                                <th data-sortable="true">Cleaning frequency</th>
                                                <th data-sortable="true">Morning</th>
                                                <th data-sortable="true">Afternoon</th>
                                                <th data-sortable="true">Evening</th>
                                                <th data-sortable="true">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($cleanings)) : ?>
                                                <?php foreach ($cleanings as $cleaning) : ?>
                                                    <tr>
                                                        <td><?= $cleaning['cleaning_frequency'] ?></td>
                                                        <td>
                                                            <?= !empty($cleaning['morning_cleaning_time']) ? date('h:i A', strtotime($cleaning['morning_cleaning_time'])) : 'N/A'; ?>
                                                        </td>
                                                        <td>
                                                            <?= !empty($cleaning['noon_cleaning_time']) ? date('h:i A', strtotime($cleaning['noon_cleaning_time'])) : 'N/A'; ?>
                                                        </td>
                                                        <td>
                                                            <?= !empty($cleaning['evening_cleaning_time']) ? date('h:i A', strtotime($cleaning['evening_cleaning_time'])) : 'N/A'; ?>
                                                        </td>
                                                        <td>
                                                            <a href="editCleaningPeriod.php?id=<?= $cleaning['cleaning_id'] ?>" class="btn btn-primary"><i class="bi bi-pencil"></i></a>
                                                            <a href="deleteCleaningPeriod.php?id=<?= $cleaning['cleaning_id'] ?>" class="btn btn-danger"><i class="bi bi-trash"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="5">No Cleaning Period found.</td>
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
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header mb-2">
                            <i class="bi bi-plus-circle"></i> Add Cleaning Period
                        </div>
                        <div class="card-body">
                            <form action="addCleaningPeriod.php" method="post">
                                <div class="mb-3">
                                    <label for="cleaningFrequency" class="form-label">Cleaning Frequency</label>
                                    <select name="cleaningFrequency" id="cleaningFrequency" class="form-select">
                                        <option value="once">Once a day</option>
                                        <option value="twice">Twice a day</option>
                                        <option value="thrice">Thrice a day</option>
                                        <option value="custom">Custom</option>
                                    </select>
                                </div>
                                <div id="cleaningTimes">
                                    <div class="mb-3">
                                        <label for="morningTime" class="form-label">Morning Cleaning Time</label>
                                        <input type="time" name="morningTime" id="morningTime" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label for="noonTime" class="form-label">Afternoon Cleaning Time</label>
                                        <input type="time" name="noonTime" id="noonTime" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label for="eveningTime" class="form-label">Evening Cleaning Time</label>
                                        <input type="time" name="eveningTime" id="eveningTime" class="form-control">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
        document.addEventListener('DOMContentLoaded', function() {
            const cleaningFrequency = document.getElementById('cleaningFrequency');
            const cleaningTimes = document.getElementById('cleaningTimes');
            const morningTime = document.getElementById('morningTime');
            const noonTime = document.getElementById('noonTime');
            const eveningTime = document.getElementById('eveningTime');

            function updateCleaningTimes() {
                const frequency = cleaningFrequency.value;
                morningTime.parentElement.style.display = 'block';
                noonTime.parentElement.style.display = frequency === 'thrice' || frequency === 'custom' ? 'block' : 'none';
                eveningTime.parentElement.style.display = frequency === 'twice' || frequency === 'thrice' || frequency === 'custom' ? 'block' : 'none';
            }

            cleaningFrequency.addEventListener('change', updateCleaningTimes);
            updateCleaningTimes();
        });
    </script>
</body>

</html>