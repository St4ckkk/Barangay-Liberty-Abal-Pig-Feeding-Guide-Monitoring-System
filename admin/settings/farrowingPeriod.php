<?php

require_once '../core/settingsController.php';
require_once '../core/notificationController.php';
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: index.php');
    exit();
}
$notificationController = new notificationController();
$currentTime = date('Y-m-d H:i:s');
$notifications = $notificationController->getNotification();
$settingsController = new settingsController();

$farrowingPeriods = $settingsController->getFarrowingPeriods();
$pigpen = $settingsController->getPigPens();
$maleSires = $settingsController->getMaleSire();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Farrowing Period</title>
    <meta content="Dashboard for sow farrowing period monitoring" name="description">
    <meta content="sow, farrowing, monitoring, dashboard" name="keywords">

    <link href="../assets/img/pig-logo.png" rel="icon">
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
</head>

<style>
    tr th {
        font-size: 12px;
    }

    .btn {
        width: 60px;
        padding: 2px;
        font-size: 12px;
    }
</style>

<body>
    <?php
    include_once '../partials/navbar.php';
    include_once '../partials/sidebar.php';
    ?>

    <main id="main" class="main" style="margin-top: 100px;">
        <div class="pagetitle">
            <h1>Farrowing Period</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Settings</li>
                    <li class="breadcrumb-item active">Farrowing</li>
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
                            <span>Farrowing Periods</span>
                        </div>
                        <div class="card-body">
                            <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                                <div class="datatable-top">
                                    <div class="datatable-dropdown">
                                        <div class="float-end">
                                            <button type="button" class="btn btn-primary float-end mb-3" data-bs-toggle="modal" data-bs-target="#addFarrowingPeriodModal">
                                                Add <i class="bi bi-plus"></i>
                                            </button>
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
                                                <th data-sortable="true">Pen #</th>
                                                <th data-sortable="true">ETN (Ear Tag Number)</th>
                                                <th data-sortable="true">Breeding Date</th>
                                                <th data-sortable="true">Expected Farrowing Date</th>
                                                <th data-sortable="true">Actual Farrowing Date</th>
                                                <th data-sortable="true">Sire</th>
                                                <th data-sortable="true">Pregnancy Status</th>
                                                <th data-sortable="true">Health Status</th>
                                                <th data-sortable="true">Litter Size</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($farrowingPeriods)) : ?>
                                                <?php foreach ($farrowingPeriods as $period) : ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($period['pen_number']) ?></td>
                                                        <td><?= htmlspecialchars($period['etn']) ?></td>
                                                        <td><?= htmlspecialchars($period['breeding_date']) ?></td>
                                                        <td><?= htmlspecialchars($period['expected_farrowing_date']) ?></td>
                                                        <td><?= htmlspecialchars($period['actual_farrowing_date']) ?></td>
                                                        <td><?= htmlspecialchars($period['sire']) ?></td>
                                                        <td><?= htmlspecialchars($period['pregnancy_status']) ?></td>
                                                        <td><?= htmlspecialchars($period['health_status']) ?></td>
                                                        <td><?= htmlspecialchars($period['litter_size']) ?></td>
                                                        <td>
                                                            <a href="editFarrowingPeriod.php?id=<?= htmlspecialchars($period['pig_id']) ?>" class="btn btn-primary"><i class="bi bi-pencil"></i></a>
                                                            <a href="deleteFarrowingPeriod.php?id=<?= htmlspecialchars($period['pig_id']) ?>" class="btn btn-danger"><i class="bi bi-trash"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td colspan="10">No Farrowing Periods found.</td>
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

    <!-- Add Farrowing Period Modal -->
    <div class="modal fade" id="addFarrowingPeriodModal" tabindex="-1" aria-labelledby="addFarrowingPeriodModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFarrowingPeriodModalLabel">Add Farrowing Period</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="addFarrowingPeriod.php" method="post">
                        <div class="row col-md-12">
                            <div class="col-md-6 mb-3">
                                <label for="penno" class="form-label">Pen no</label>
                                <select name="penno" id="penno" class="form-control">
                                    <option value="" disabled selected>Select Pen</option>
                                    <?php foreach ($pigpen as $pen) : ?>
                                        <option value="<?= $pen['penId'] ?>"><?= $pen['penno'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="pigs" class="form-label">Dams</label>
                                <select name="dams" id="pigsSelect" class="form-select" disabled>
                                    <option value="" disabled selected>--Select Dams--</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="sire" class="form-label">Sire</label>
                                <select name="sire" id="sireSelect" class="form-select">
                                    <option value="" disabled selected>--Select Sire--</option>
                                    <?php foreach ($maleSires as $sires) : ?>
                                        <option value="<?= $sires['ear_tag_number'] ?>"><?= $sires['ear_tag_number'] ?> - <?= $sires['breed'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="health_status" class="form-label">Health Status</label>
                                <select name="health_status" class="form-select">
                                    <option value="" disabled selected>--Select Status--</option>
                                    <option value="Healthy">Healthy</option>
                                    <option value="Sick">Sick</option>
                                    <option value="Injured">Injured</option>
                                    <option value="Under Observation">Under Observation</option>
                                    <option value="Recovering">Recovering</option>
                                    <option value="Deceased">Deceased</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="breeding_date" class="form-label">Breeding Date</label>
                                <input type="date" class="form-control" name="breeding_date" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="expected_farrowing_date" class="form-label">Expected Farrowing Date</label>
                                <input type="date" class="form-control" name="expected_farrowing_date" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="pregnancy_status" class="form-label">Pregnancy Status</label>
                                <select name="pregnancy_status" class="form-select">
                                    <option value="" disabled selected>--Select Status--</option>
                                    <option value="Not Pregnant">Not Pregnant</option>
                                    <option value="Pregnant">Pregnant</option>
                                    <option value="Aborted">Aborted</option>
                                    <option value="Farowed">Farowed</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="litter_size" class="form-label">Litter Size</label>
                                <input type="number" class="form-control" name="litter_size">
                            </div>
                            <div class="mb-3">
                                <label for="litter_size" class="form-label">Additional Notes</label>
                                <textarea name="notes" id="" class="form-control"></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Submit</button>
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
        document.addEventListener('DOMContentLoaded', function() {
            const damsSelect = document.getElementById('pigsSelect');
            const sireSelect = document.getElementById('sireSelect');
            const nameInputs = document.getElementById('nameInputs');
            const penSelect = document.getElementById('penno');

            function checkSelections() {
                if (damsSelect.value && sireSelect.value) {
                    nameInputs.style.display = 'block';
                } else {
                    nameInputs.style.display = 'none';
                }
            }

            damsSelect.addEventListener('change', checkSelections);
            sireSelect.addEventListener('change', checkSelections);

            penSelect.addEventListener('change', function() {
                const selectedPenId = this.value;
                if (selectedPenId) {
                    fetch(`fetchParrowingPigs.php?pen_id=${selectedPenId}`)
                        .then(response => response.json())
                        .then(data => {
                            damsSelect.innerHTML = '<option value="" disabled selected>--Select Dams--</option>';
                            data.forEach(pig => {
                                const option = document.createElement('option');
                                option.value = pig.pig_id;
                                option.textContent = `${pig.ear_tag_number} - ${pig.breed}`;
                                damsSelect.appendChild(option);
                            });
                            damsSelect.disabled = false;
                            checkSelections();
                        })
                        .catch(error => console.error('Error:', error));
                } else {
                    damsSelect.innerHTML = '<option value="" disabled selected>--Select Dams--</option>';
                    damsSelect.disabled = true;
                    checkSelections();
                }
            });
        });
    </script>
</body>

</html>