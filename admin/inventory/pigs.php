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

    <link href="../assets/css/global.css" rel="stylesheet">

    <style>
        .table td {
            font-size: 12px;
        }

        .btn {
            width: 60px;
            padding: 2px;
            font-size: 12px;
        }

        .add {
            width: 100px;
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
                            <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                                <div class="datatable-top">
                                    <div class="datatable-dropdown">
                                        <div class="float-end">
                                            <button type="button" class="add btn btn-primary float-end mb-3" data-bs-toggle="modal" data-bs-target="#addPigModal">
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
                                                <th data-sortable="true">ETN</th>
                                                <th data-sortable="true">Status</th>
                                                <th data-sortable="true">Gender</th>
                                                <th data-sortable="true">Type</th>
                                                <th data-sortable="true">Breed</th>
                                                <th data-sortable="true">Weight</th>
                                                <th data-sortable="true">Age</th>
                                                <th data-sortable="true">Notes</th>
                                                <th data-sortable="true">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($pigs)) : ?>
                                                <?php foreach ($pigs as $pig) : ?>
                                                    <tr>
                                                        <td><strong><?= $pig['ear_tag_number'] ?></strong></td>
                                                        <td><?= $pig['status'] ?></td>
                                                        <td><?= $pig['gender'] ?></td>
                                                        <td><?= $pig['pig_type'] ?></td>
                                                        <td><?= $pig['breed'] ?></td>
                                                        <td><?= $pig['weight'] ?></td>
                                                        <td><?= $pig['age'] ?></td>
                                                        <td><?= $pig['notes'] ?></td>
                                                        <td>
                                                            <a href="#" class="btn btn-primary edit-button" data-bs-toggle="modal" data-bs-target="#editPigModal" data-pig='<?= json_encode($pig) ?>'><i class="bi bi-pencil"></i></a>
                                                            <a href="#" class="btn btn-danger delete-button" data-bs-toggle="modal" data-bs-target="#deletePigModal" data-pig-id="<?= $pig['pig_id'] ?>"><i class="bi bi-trash"></i></a>

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
                                    <input type="text" class="form-control" id="earTagNumber" name="etn" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="pigStatus" class="form-control">
                                        <option value="" selected disabled>Select a Status of The Pig</option>
                                        <option value="none">None</option>
                                        <option value="healthy">Healthy</option>
                                        <option value="sick">Sick</option>
                                        <option value="dead">Dead</option>
                                        <option value="injured">Injured</option>
                                        <option value="ready_for_slaughter">Ready For Slaughter</option>
                                        <option value="ready_for_breeding">Ready For Breeding</option>
                                        <option value="ready_for_selling">Ready For Selling</option>
                                        <option value="in_breeding">In Breeding</option>
                                        <option value="pregnant">Pregnant</option>
                                        <option value="lactating">Lactating</option>
                                        <option value="underweight">Underweight</option>
                                        <option value="overweight">Overweight</option>
                                        <option value="weaning">Weaning</option>
                                        <option value="sold">Sold</option>
                                        <option value="quarantined">Quarantined</option>
                                        <option value="vaccinated">Vaccinated</option>
                                        <option value="recovered">Recovered</option>
                                        <option value="being_transported">Being Transported</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="status" class="form-label">Pig Type</label>
                                    <select name="pigType" id="pigType" class="form-control">
                                        <option value="" selected disabled>Select Pig Type</option>
                                        <option value="piglet">Piglet</option>
                                        <option value="weaner">Weaner</option>
                                        <option value="grower">Grower</option>
                                        <option value="finisher">Finisher</option>
                                        <option value="sow">Sow</option>
                                        <option value="gilt">Gilt</option>
                                        <option value="boar">Boar</option>
                                        <option value="barrow">Barrow</option>
                                        <option value="stag">Stag</option>
                                        <option value="shoat">Shoat</option>
                                        <option value="farrow">Farrow</option>
                                        <option value="hog">Hog</option>
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
                                    <label for="breed" class="form-label">Breed</label>
                                    <input type="text" class="form-control" id="breed" name="breed" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="weight" class="form-label">Weight</label>
                                    <input type="number" class="form-control" id="weight" name="weight" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="age" class="form-label">Age</label>
                                    <input type="text" class="form-control" id="age" name="age" required>
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


    <div class="modal fade" id="editPigModal" tabindex="-1" aria-labelledby="editPigModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> <!-- modal-lg for a larger modal -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPigModalLabel">Edit Pig Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="editPig.php" method="post">
                        <input type="hidden" name="pig_id" id="editPigId" value="">

                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editEarTagNumber" class="form-label">Ear Tag Number</label>
                                    <input type="text" class="form-control" id="editEarTagNumber" name="etn" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editPigStatus" class="form-label">Status</label>
                                    <select name="status" id="editPigStatus" class="form-control">
                                        <option value="" selected disabled>Select Status</option>
                                        <!-- Add status options here -->
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="editPigType" class="form-label">Pig Type</label>
                                    <select name="pigType" id="editPigType" class="form-control">
                                        <option value="" selected disabled>Select Pig Type</option>
                                        <!-- Add pig type options here -->
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="editGender" class="form-label">Gender</label>
                                    <select name="gender" id="editGender" class="form-control">
                                        <option value="" selected disabled>Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editBreed" class="form-label">Breed</label>
                                    <input type="text" class="form-control" id="editBreed" name="breed">
                                </div>
                                <div class="mb-3">
                                    <label for="editWeight" class="form-label">Weight</label>
                                    <input type="number" class="form-control" id="editWeight" name="weight" step="0.01">
                                </div>
                                <div class="mb-3">
                                    <label for="editAge" class="form-label">Age</label>
                                    <input type="number" class="form-control" id="editAge" name="age">
                                </div>
                                <div class="mb-3">
                                    <label for="editNotes" class="form-label">Notes</label>
                                    <textarea class="form-control" id="editNotes" name="notes" rows="3"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="deletePigModal" tabindex="-1" aria-labelledby="deletePigModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletePigModalLabel">Delete Pig</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this pig?</p>
                    <form action="deletePig.php" method="post">
                        <input type="hidden" name="pig_id" id="deletePigId" value="">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="../assets/js/main.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle Edit Modal
            const editButtons = document.querySelectorAll('.edit-button'); // assuming class 'edit-button' for edit buttons
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const pig = JSON.parse(this.getAttribute('data-pig')); // assumes pig data in a 'data-pig' attribute
                    document.getElementById('editPigId').value = pig.pig_id;
                    document.getElementById('editEarTagNumber').value = pig.ear_tag_number;
                    document.getElementById('editPigStatus').value = pig.status;
                    document.getElementById('editPigType').value = pig.pig_type;
                    document.getElementById('editGender').value = pig.gender;
                    document.getElementById('editBreed').value = pig.breed;
                    document.getElementById('editWeight').value = pig.weight;
                    document.getElementById('editAge').value = pig.age;
                    document.getElementById('editNotes').value = pig.notes;
                });
            });

            // Handle Delete Modal
            const deleteButtons = document.querySelectorAll('.delete-button'); // assuming class 'delete-button' for delete buttons
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const pigId = this.getAttribute('data-pig-id');
                    document.getElementById('deletePigId').value = pigId;
                });
            });
        });
    </script>
</body>

</html>