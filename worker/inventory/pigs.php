<?php
require_once '../core/Database.php';
require_once '../core/inventoryController.php';
require_once '../core/notificationController.php';

$notificationController = new notificationController();
$currentTime = date('Y-m-d H:i:s');
$notifications = $notificationController->getNotification();
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: index.php');
    exit();
}

$penId = isset($_GET['penId']) ? (int)$_GET['penId'] : 0;
$pigs = [];
$penno = '';

if ($penId) {
    $inventoryController = new inventoryController();
    $pigs = $inventoryController->getPigs($penId);
    $penno = $inventoryController->getPenNo($penId);
}

$sched = $inventoryController->getFeedingSched();

$inputId = $penId;
$success = '';
$error = '';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Pigs List</title>
    <meta content="Dashboard for pig monitoring" name="description">
    <meta content="pig, monitoring, dashboard" name="keywords">

    <link href="../assets/img/pig-logo.png" rel="icon">
    <link href="../assets/img/pig-logo.png" rel="apple-touch-icon">

    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <link href="../assets/css/style.css" rel="stylesheet">

    <style>
        .table td {
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
            <h1><?= $penno ? $penno : 'Unknown' ?> Pigs List</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Pigs</li>
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
                            <span>Pigs List</span>
                        </div>
                        <div class="card-body">
                            <!-- <div class="float-start mb-3 d-flex">
                                <form>
                                    <input type="hidden" name="penId" value="<?= $inputId; ?>">
                                    <select class="form-select float-start me-2" name="schedId" aria-label="Select Feeding Time" onchange="showConfirmModal(this)">
                                        <option selected>Select Feeding Time</option>
                                        <?php foreach ($sched as $s) : ?>
                                            <?php
                                            $formattedTime = date('h:i A', strtotime($s['schedTime']));
                                            ?>
                                            <option value="<?= $s['schedId'] ?>"><?= $formattedTime ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </form>

                            </div> -->
                            <div class="float-end">
                                <button type="button" class="btn btn-primary float-end mb-3" data-bs-toggle="modal" data-bs-target="#addPigModal">
                                    Add Pig <i class="bi bi-plus"></i>
                                </button>

                            </div>
                            <table class="table table-bordered">
                                <thead>
                                    <th scope="col">ETN</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Gender</th>
                                    <th scope="col">Health Status</th>
                                    <th scope="col">Breed</th>
                                    <th scope="col">Acquisition Date</th>
                                    <th scope="col">Weight</th>
                                    <th scope="col">Age</th>
                                    <th scope="col">Notes</th>
                                    <th scope="col">Action</th>
                                </thead>
                                <tbody>
                                    <?php if (!empty($pigs)) : ?>
                                        <?php foreach ($pigs as $pig) : ?>
                                            <tr>
                                                <td><?= $pig['ear_tag_number'] ?></td>
                                                <td><?= $pig['status'] ?></td>
                                                <td><?= $pig['gender'] ?></td>
                                                <td><?= $pig['health_status'] ?></td>
                                                <td><?= $pig['breed'] ?></td>
                                                <td><?= $pig['acquisition_date'] ?></td>
                                                <td><?= $pig['weight'] ?></td>
                                                <td><?= $pig['age'] ?></td>
                                                <td><?= $pig['notes'] ?></td>
                                                <td>
                                                    <a href="editPig.php?id=<?= $pig['pig_id'] ?>" class="btn btn-primary"><i class="bi bi-pencil"></i></a>
                                                    <a href="deletePig.php?id=<?= $pig['pig_id'] ?>" class="btn btn-danger"><i class="bi bi-trash"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="13">No pigs found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="modal fade" id="confirmFeedingTimeModal" tabindex="-1" aria-labelledby="confirmFeedingTimeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmFeedingTimeModalLabel">Confirm Feeding Time</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to set this feeding time for Pen #<span><?= $penno ? $penno : 'Unknown' ?>?</span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="confirmFeedingTimeBtn">Confirm</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="addPigModal" tabindex="-1" aria-labelledby="addPigModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPigModalLabel">Add New Pig</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="addPigs.php" method="post">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <input type="hidden" class="form-control" id="penId" name="penId" value="<?= $inputId; ?>">
                                    <label for="earTagNumber" class="form-label">Ear Tag Number</label>
                                    <input type="text" class="form-control" id="earTagNumber" name="ear_tag_number" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="" class="form-control">
                                        <option value="" selected disabled>Select a Status of The Pig</option>
                                        <option value="none">None</option>
                                        <option value="ready for slaughter">Ready For Slaughter</option>
                                        <option value="ready for breeding">Ready For Breeding</option>
                                        <option value="ready for selling">Ready For Selling</option>
                                        <option value="in breeding">In Breeding</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select name="gender" id="" class="form-control">
                                        <option value="" selected disabled>Select the Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="healthStatus" class="form-label">Health Status</label>
                                    <select name="health_status" id="" class="form-control">
                                        <option value="" selected disabled>Select the Health Status</option>
                                        <option value="healthy">Healthy</option>
                                        <option value="sick">Sick</option>
                                        <option value="injured">injured</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="breed" class="form-label">Breed</label>
                                    <input type="text" class="form-control" id="breed" name="breed" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="acquisitionDate" class="form-label">Acquisition Date</label>
                                    <input type="date" class="form-control" id="acquisitionDate" name="acquisition_date" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="weight" class="form-label">Weight</label>
                                    <input type="number" class="form-control" id="weight" name="weight" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="age" class="form-label">Age</label>
                                    <input type="number" class="form-control" id="age" name="age" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea name="notes" id="notes" class="form-control"></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="../assets/js/main.js"></script>

    <!-- <script>
        function showConfirmModal(selectElement) {
            const modal = new bootstrap.Modal(document.getElementById('confirmFeedingTimeModal'));
            modal.show();
            document.getElementById('confirmFeedingTimeBtn').onclick = function() {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'updateFeedingSched.php';

                const penIdInput = document.createElement('input');
                penIdInput.type = 'hidden';
                penIdInput.name = 'penId';
                penIdInput.value = '<?= $inputId; ?>'; // Use the hidden input value

                const feedingTimeInput = document.createElement('input');
                feedingTimeInput.type = 'hidden';
                feedingTimeInput.name = 'schedId';
                feedingTimeInput.value = selectElement.value; // Use selected value from dropdown

                form.appendChild(penIdInput);
                form.appendChild(feedingTimeInput);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script> -->

</body>

</html>